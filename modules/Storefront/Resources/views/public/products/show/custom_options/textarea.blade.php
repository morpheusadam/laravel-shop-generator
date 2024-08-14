<div class="form-group variant-input">
    <div class="row">
        <div class="col-lg-8">
            <label for="option-{{ $option->id }}">
                {!!
                    $option->name .
                    $option->values->first()->formattedPriceForProduct($product) .
                    ($option->is_required ? '<span>*</span>' : '')
                !!}
            </label>
        </div>

        <div class="col-lg-18">
            <div class="form-input">
                <textarea
                    class="form-control"
                    name="options[{{ $option->id }}]"
                    id="option-{{ $option->id }}"
                    v-model="cartItemForm.options[{{ $option->id }}]"
                ></textarea>
            </div>

            <span
                class="error-message"
                v-if="errors.has('{{ "options.{$option->id}" }}')"
                v-text="errors.get('{{ "options.{$option->id}" }}')"
            >
            </span>
        </div>
    </div>
</div>
