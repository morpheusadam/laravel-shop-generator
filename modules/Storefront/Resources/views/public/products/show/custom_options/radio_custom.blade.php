<div class="form-group variant-custom-selection">
    <div class="row">
        <div class="col-lg-18">
            <label>
                {!!
                    $option->name .
                    ($option->is_required ? '<span>*</span>' : '')
                !!}
            </label>
        </div>

        <div class="col-lg-18">
            <ul class="list-inline form-custom-radio custom-selection">
                @foreach ($option->values as $value)
                    <li
                        :class="{ active: customRadioTypeOptionValueIsActive({{ $option->id }}, {{ $value->id }}) }"
                        @click="syncCustomRadioTypeOptionValue({{ $option->id }}, {{ $value->id }})"
                    >
                        {!!
                            $value->label .
                            $value->formattedPriceForProduct($product)
                        !!}
                    </li>
                @endforeach
            </ul>

            <span
                class="error-message"
                v-if="errors.has('{{ "options.{$option->id}" }}')"
                v-text="errors.get('{{ "options.{$option->id}" }}')"
            >
        </div>
    </div>
</div>
