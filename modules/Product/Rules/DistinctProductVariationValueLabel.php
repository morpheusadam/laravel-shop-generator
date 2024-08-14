<?php

namespace Modules\Product\Rules;

use Illuminate\Contracts\Validation\Rule;

class DistinctProductVariationValueLabel implements Rule
{
    /**
     * All the data under validation.
     *
     * @var array
     */
    protected array $data = [];


    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!request($attribute)) {
            return true;
        }

        $explodedAttributes = explode(".", $attribute);

        array_pop($explodedAttributes);
        array_pop($explodedAttributes);

        $attribute = join(".", $explodedAttributes);

        return !(array_count_values(
                array_filter(
                    array_pluck(
                        array_filter(
                            request($attribute)
                        ), 'label'
                    )
                )
            )[$value] > 1);
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('core::validation.distinct');
    }
}
