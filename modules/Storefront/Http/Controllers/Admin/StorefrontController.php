<?php

namespace Modules\Storefront\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\Storefront\Http\Requests\SaveStorefrontRequest;

class StorefrontController
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        $settings = setting()->all();
        $tabs = TabManager::get('storefront');

        return view('storefront::admin.storefront.edit', compact('settings', 'tabs'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(SaveStorefrontRequest $request)
    {
        setting($request->except('_token', '_method'));

        return back()->withSuccess(trans('admin::messages.resource_updated', ['resource' => trans('setting::settings.settings')]));
    }
}
