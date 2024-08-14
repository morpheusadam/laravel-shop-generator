<?php

namespace Modules\Cart\Http\Controllers;

use Modules\Cart\Facades\Cart;
use Illuminate\Support\Collection;

class CartCrossSellProductsController
{
    /**
     * Display a listing of the resource.
     *
     * @return  Collection
     */
    public function index(): Collection
    {
        return Cart::crossSellProducts();
    }
}
