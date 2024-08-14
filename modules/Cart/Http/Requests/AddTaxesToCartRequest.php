<?php

namespace Modules\Cart\Http\Requests;

use Modules\Core\Http\Requests\Request;

class AddTaxesToCartRequest extends Request
{
    protected function passedValidation()
    {
        $this->merge([
            'shipping' => $this->input('ship_to_a_different_address')
                ? $this->input('shipping')
                : $this->input('billing'),
        ]);
    }
}
