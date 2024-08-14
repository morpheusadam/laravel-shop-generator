<?php

namespace Modules\Variation\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;
use Modules\Variation\Entities\Variation;

class SaveVariationRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'variation::attributes';


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'type' => ['required', Rule::in(Variation::TYPES)],
            'values' => 'array|min:1',
            'values.*.label' => 'required|distinct',
            'values.*.color' => 'required_if:type,color|regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/',
            'values.*.image' => 'required_if:type,image',
        ];
    }


    public function __validationData(): array
    {
        return request()
            ->merge([
                'values' => $this->filter($this->values ?? []),
            ])
            ->all();
    }


    private function filter($values = [])
    {
        return array_filter($values, function ($value) {
            if (!array_has($value, 'label')) {
                return true;
            }

            return !is_null($value['label']);
        });
    }
}
