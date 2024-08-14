<?php

namespace Modules\Support\Http\Controllers;

use Modules\Support\State;
use Illuminate\Http\Response;

class CountryStateController
{
    /**
     * Display a listing of the resource.
     *
     * @param string $countryCode
     *
     * @return Response
     */
    public function index($countryCode)
    {
        $states = State::get($countryCode);

        return response()->json($states);
    }
}
