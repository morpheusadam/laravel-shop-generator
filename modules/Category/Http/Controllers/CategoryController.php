<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Category\Entities\Category;

class CategoryController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('storefront::public.categories.index', [
            'categories' => Category::all()->nest(),
        ]);
    }
}
