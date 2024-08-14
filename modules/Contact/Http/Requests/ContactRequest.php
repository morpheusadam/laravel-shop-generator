<?php

namespace Modules\Contact\Http\Requests;

use Modules\Core\Http\Requests\Request;
use Modules\Support\Rules\GoogleRecaptcha;

class ContactRequest extends Request
{
    protected $availableAttributes = 'contact::attributes';


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'subject' => ['required'],
            'message' => ['required'],
            'g-recaptcha-response' => ['bail', 'sometimes', 'required', new GoogleRecaptcha()],
        ];
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), [
            'g-recaptcha-response.required' => trans('support::recaptcha.validation.failed_to_verify'),
        ]);
    }
}
