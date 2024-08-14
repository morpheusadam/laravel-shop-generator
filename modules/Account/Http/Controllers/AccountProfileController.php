<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Response;
use Modules\User\Http\Requests\UpdateProfileRequest;

class AccountProfileController
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('storefront::public.account.profile.edit', [
            'account' => auth()->user(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfileRequest $request
     *
     * @return Response
     */
    public function update(UpdateProfileRequest $request)
    {
        $request->bcryptPassword();

        auth()->user()->update($request->all());

        return back()->with('success', trans('account::messages.profile_updated'));
    }
}
