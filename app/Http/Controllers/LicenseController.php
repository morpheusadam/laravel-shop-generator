<?php

namespace FleetCart\Http\Controllers;

use FleetCart\License;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use FleetCart\Http\Middleware\RedirectIfShouldNotCreateLicense;

class LicenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfShouldNotCreateLicense::class);
    }


    public function create(): Factory|View|Application
    {
        return view('license.create');
    }


    public function store(License $license): RedirectResponse
    {
        request()->validate(
            [
                'purchase_code' => 'required',
            ],
            [
                'required' => 'The purchase code field is required.',
            ]
        );

        $license->activate(request('purchase_code'));

        return redirect()->intended();
    }
}
