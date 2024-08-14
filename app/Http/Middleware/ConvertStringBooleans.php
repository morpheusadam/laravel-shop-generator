<?php

namespace FleetCart\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertStringBooleans extends TransformsRequest
{
    /**
     * Transform the given value.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    protected function transform($key, $value): mixed
    {
        if ($value === 'true' || $value === 'TRUE') {
            return true;
        }

        if ($value === 'false' || $value === 'FALSE') {
            return false;
        }

        return $value;
    }
}
