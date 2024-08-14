<?php

namespace Modules\Storefront\Http\Controllers;

use Illuminate\Http\Response;
use Modules\FlashSale\Entities\FlashSale;

class FlashSaleProductController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return FlashSale::active()->products->map->clean();
    }
}
