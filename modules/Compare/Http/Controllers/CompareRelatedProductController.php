<?php

namespace Modules\Compare\Http\Controllers;

use Modules\Compare\Compare;
use Illuminate\Http\Response;

class CompareRelatedProductController
{
    /**
     * Display a listing of the resource.
     *
     * @param Compare $compare
     *
     * @return Response
     */
    public function index(Compare $compare)
    {
        return $compare->relatedProducts();
    }
}
