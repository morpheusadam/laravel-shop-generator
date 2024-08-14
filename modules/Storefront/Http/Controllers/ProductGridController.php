<?php

namespace Modules\Storefront\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Storefront\Http\Controllers\ProductIndexController;

class ProductGridController extends ProductIndexController
{
    /**
     * Display a listing of the resource.
     *
     * @param int $tabNumber
     *
     * @return Response
     */
    public function index($tabNumber)
    {
        return $this->getProducts("storefront_product_grid_section_tab_{$tabNumber}");
    }
}
