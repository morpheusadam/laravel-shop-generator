<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Review\Entities\Review;
use Illuminate\Contracts\View\View;
use Modules\Product\Entities\Product;
use Illuminate\Contracts\View\Factory;
use Modules\Product\Events\ProductViewed;
use Modules\Product\Filters\ProductFilter;
use Illuminate\Contracts\Foundation\Application;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Http\Middleware\SetProductSortOption;

class ProductController extends Controller
{
    use ProductSearch;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(SetProductSortOption::class)->only('index');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Product $model
     * @param ProductFilter $productFilter
     *
     * @return JsonResponse|Application|Factory|View
     */
    public function index(Product $model, ProductFilter $productFilter)
    {
        if (request()->expectsJson()) {
            return $this->searchProducts($model, $productFilter);
        }

        return view('storefront::public.products.index');
    }


    /**
     * Show the specified resource.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function show($slug)
    {
        $product = ProductRepository::findBySlug($slug);
        $relatedProducts = $product->relatedProducts()->with('variants')->forCard()->get();
        $upSellProducts = $product->upSellProducts()->with('variants')->forCard()->get();
        $review = $this->getReviewData($product);

        $product->append([
            'is_in_flash_sale',
            'flash_sale_end_date',
            'formatted_price_range',
        ]);

        $requestedVariant = request()->query('variant');

        if ($requestedVariant) {
            $product->variant = $product->variants()
                ->withoutGlobalScope('active')
                ->where('uid', $requestedVariant)
                ->firstOrFail();
        }

        event(new ProductViewed($product));

        return view('storefront::public.products.show', compact('product', 'relatedProducts', 'upSellProducts', 'review'));
    }


    private function getReviewData(Product $product)
    {
        if (!setting('reviews_enabled')) {
            return null;
        }

        return Review::countAndAvgRating($product);
    }
}
