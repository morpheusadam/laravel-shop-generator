<?php

namespace Modules\Storefront\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Storefront\Http\Controllers\ProductIndexController;

class TabProductController extends ProductIndexController
{
    /**
     * Display a listing of the resource.
     *
     * @param int $sectionNumber
     * @param int $tabNumber
     *
     * @return Response
     */
    public function index($sectionNumber, $tabNumber)
    {
        return $this->getProducts("storefront_product_tabs_{$sectionNumber}_section_tab_{$tabNumber}");
    }
}
