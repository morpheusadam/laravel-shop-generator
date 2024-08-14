<?php

namespace Modules\Cart\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Option\Entities\Option;
use Modules\Product\Entities\Product;
use Modules\Core\Http\Requests\Request;
use Modules\Product\Entities\ProductVariant;
use Illuminate\Database\Eloquent\Collection;

class StoreCartItemRequest extends Request
{

    protected Product|null $product;
    protected ProductVariant|null $variant;
    protected Product|ProductVariant $item;


    public function __construct(...$args)
    {
        parent::__construct(...$args);

        $this->product = $this->getProduct();
        $this->variant = $this->getVariant();

        $this->item = $this->variant ?? $this->product;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getOptionsRules($this->product->options);
    }


    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return array_merge(
            $this->all(),
            [
                'options' => array_filter($this->options ?? []),
            ]
        );
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge([
            'options.*.required' => trans('cart::validation.this_field_is_required'),
            'options.*.in' => trans('cart::validation.the_selected_option_is_invalid'),
        ], parent::messages());
    }



    private function getProduct()
    {
        $product_id = request()->input('product_id');

        return Product::with('options')
            ->select('id', 'manage_stock', 'qty', 'is_active')
            ->find($product_id);
    }


    private function getVariant()
    {
        $variant_id = request()->input('variant_id');

        if ($variant_id) {
            return ProductVariant::select('id', 'manage_stock', 'qty', 'is_active')
                ->find($variant_id);
        }
    }



    /**
     * Get rules for the given options.
     *
     * @param Collection $options
     *
     * @return array
     */
    private function getOptionsRules($options)
    {
        return $options->flatMap(function ($option) {
            return ["options.{$option->id}" => $this->getOptionRules($option)];
        })->all();
    }


    /**
     * Get rules for the given option.
     *
     * @param Option $option
     *
     * @return array
     */
    private function getOptionRules($option)
    {
        $rules = [];

        if ($option->is_required) {
            $rules[] = 'required';
        }

        if (in_array($option->type, ['dropdown', 'radio'])) {
            $rules[] = Rule::in($option->values->map->id->all());
        }

        return $rules;
    }
}
