<?php

namespace Modules\Storefront\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Storefront\Http\Controllers\ProductIndexController;

class FeaturedCategoryProductController extends ProductIndexController
{
    /**
     * Display a listing of the resource.
     *
     * @param int $categoryNumber
     *
     * @return Response
     */
    public function index($categoryNumber)
    {
        return $this->getProducts("storefront_featured_categories_section_category_{$categoryNumber}");
    }
}
