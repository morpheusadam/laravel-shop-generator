<?php

namespace Modules\Product\Http\Response;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Modules\Product\Entities\Product;
use Modules\Category\Entities\Category;
use Illuminate\Contracts\Support\Responsable;

class SuggestionsResponse implements Responsable
{
    private string $query;
    private Collection $products;
    private Collection $categories;
    private int $totalResults;


    /**
     * Create a new instance.
     *
     * @param string $query
     * @param int $totalResults
     * @param Collection $products
     * @param Collection $categories
     */
    public function __construct(string $query, Collection $products, Collection $categories, int $totalResults)
    {
        $this->query = $query;
        $this->products = $products;
        $this->categories = $categories;
        $this->totalResults = $totalResults;
    }


    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'categories' => $this->transformCategories(),
            'products' => $this->transformProducts(),
            'remaining' => $this->getRemainingCount(),
        ]);
    }


    /**
     * Transform the categories.
     *
     * @return Collection
     */
    private function transformCategories(): Collection
    {
        return $this->categories->map(function (Category $category) {
            return [
                'slug' => $category->slug,
                'name' => $category->name,
                'url' => $category->url(),
            ];
        })->unique('slug')->values();
    }


    /**
     * Transform the products.
     *
     * @return Collection
     */
    private function transformProducts(): Collection
    {
        return $this->products->map(function (Product $product) {
            return [
                'slug' => $product->slug,
                'name' => $this->highlight($product->name),
                'formatted_price' => $product->variant?->formatted_price ?? $product->formatted_price,
                'base_image' => ($product->variant && $product->variant->base_image->id) ? $product->variant->base_image : $product->base_image,
                'is_out_of_stock' => $product->variant?->isOutOfStock() ?? $product->isOutOfStock(),
                'url' => $product->variant?->url() ?? $product->url(),
            ];
        });
    }


    /**
     * Highlight the given text.
     *
     * @param string $text
     *
     * @return string
     */
    private function highlight($text): string
    {
        $query = str_replace(' ', '|', preg_quote($this->query));

        return preg_replace("/($query)/i", '<em>$1</em>', $text);
    }


    /**
     * Get remaining results count.
     *
     * @return int
     */
    private function getRemainingCount(): int
    {
        return $this->totalResults - $this->products->count();
    }
}
