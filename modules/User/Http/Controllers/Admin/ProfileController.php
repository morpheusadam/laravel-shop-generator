<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\User\Http\Requests\UpdateProfileRequest;

class ProfileController
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit()
    {
        $tabs = TabManager::get('profile');

        return view('user::admin.profile.edit', compact('tabs'));
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
        $this->bcryptPassword($request);

        auth()->user()->update($request->all());

        return back()->withSuccess(trans('admin::messages.resource_updated', [
            'resource' => trans('user::users.profile'),
        ]));
    }


    /**
     * Bcrypt user password.
     *
     * @param Request $request
     *
     * @return void
     */
    private function bcryptPassword($request)
    {
        if ($request->filled('password')) {
            return $request->merge(['password' => bcrypt($request->password)]);
        }

        unset($request['password']);
    }
}
