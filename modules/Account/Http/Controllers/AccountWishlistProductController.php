<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Product\Entities\Product;

class AccountWishlistProductController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return auth()->user()
            ->wishlist()
            ->with('files')
            ->orderByPivot('created_at', 'desc')
            ->paginate(10);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (!auth()->user()->wishlistHas(request('productId'))) {
            auth()->user()->wishlist()->attach(request('productId'));
        }
    }


    /**
     * Destroy resources by the given id.
     *
     * @param Product $product
     *
     * @return void
     */
    public function destroy(Product $product)
    {
        auth()->user()->wishlist()->detach($product);
    }
}
