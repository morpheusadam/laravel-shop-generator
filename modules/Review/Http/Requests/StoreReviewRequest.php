<?php

namespace Modules\Review\Http\Requests;

use Modules\Core\Http\Requests\Request;
use Modules\Support\Rules\GoogleRecaptcha;

class StoreReviewRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'review::attributes';


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => 'required|numeric',
            'reviewer_name' => 'required',
            'comment' => 'required',
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
