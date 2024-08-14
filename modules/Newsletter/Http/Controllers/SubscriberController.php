<?php

namespace Modules\Newsletter\Http\Controllers;

use Modules\Newsletter\Http\Requests\StoreSubscriberRequest;
use Spatie\Newsletter\Facades\Newsletter;

class SubscriberController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(StoreSubscriberRequest $request)
    {
        Newsletter::subscribeOrUpdate($request->email);

        if (!Newsletter::lastActionSucceeded()) {
            return response()->json([
                'message' => str_after(Newsletter::getLastError(), '400: '),
            ], 403);
        }
    }
}
