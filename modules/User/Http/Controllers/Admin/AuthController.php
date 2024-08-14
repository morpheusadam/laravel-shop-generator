<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Modules\User\Http\Controllers\BaseAuthController;

class AuthController extends BaseAuthController
{
    /**
     * Show login form.
     *
     * @return Response
     */
    public function getLogin()
    {
        return view('user::admin.auth.login');
    }


    /**
     * Show reset password form.
     *
     * @return Response
     */
    public function getReset()
    {
        return view('user::admin.auth.reset.begin');
    }


    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route('admin.dashboard.index');
    }


    /**
     * The login URL.
     *
     * @return string
     */
    protected function loginUrl()
    {
        return route('admin.login');
    }


    /**
     * Reset complete form route.
     *
     * @param User $user
     * @param string $code
     *
     * @return string
     */
    protected function resetCompleteRoute($user, $code)
    {
        return route('admin.reset.complete', [$user->email, $code]);
    }


    /**
     * Password reset complete view.
     *
     * @return string
     */
    protected function resetCompleteView()
    {
        return view('user::admin.auth.reset.complete');
    }
}
