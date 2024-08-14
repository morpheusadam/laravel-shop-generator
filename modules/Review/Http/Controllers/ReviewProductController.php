<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Http\Response;

class ReviewProductController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return auth()->user()
            ->reviews()
            ->withoutGlobalScope('approved')
            ->with('product.files')
            ->whereHas('product')
            ->latest()
            ->paginate(10);
    }
}
