<div class="form-group variant-select">
    <div class="row">
        <div class="col-lg-18">
            <label for="option-{{ $option->id }}">
                {!!
                    $option->name .
                    ($option->is_required ? '<span>*</span>' : '')
                !!}
            </label>
        </div>

        <div class="col-lg-18">
            @if ($option->type === 'multiple_select')
                <select
                    name="options[{{ $option->id }}][]"
                    class="form-control"
                    id="option-{{ $option->id }}"
                    @change="updateSelectTypeOptionValue({{ $option->id }}, $event)"
                    multiple
                >
            @else
                <select
                    v-cloak
                    name="options[{{ $option->id }}]"
                    class="form-control custom-select-option arrow-black"
                    id="option-{{ $option->id }}"
                    @nice-select-updated="updateSelectTypeOptionValue({{ $option->id }}, $event)"
                >
            @endif
                @if ($option->type === 'dropdown')
                    <option value="" selected>{{ trans('storefront::product.options.choose_an_option') }}</option>
                @endif

                @foreach ($option->values as $value)
                    <option value="{{ $value->id }}">
                        {!!
                            "{$value->label} " .
                            $value->formattedPriceForProduct($product, FOR_SELECT_OPTION)
                        !!}
                    </option>
                @endforeach
            </select>

            <span
                class="error-message"
                v-if="errors.has('{{ "options.{$option->id}" }}')"
                v-text="errors.get('{{ "options.{$option->id}" }}')"
            >
            </span>
        </div>
    </div>
</div>
