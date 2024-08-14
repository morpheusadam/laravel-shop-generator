<template v-if="section === 'price'">
    <div class="box-header">
        <h5>{{ trans('product::products.group.pricing') }}</h5>

        <div class="drag-handle">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
    </div>

    <div class="box-body">
        <div v-if="hasAnyVariant" class="alert alert-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM11.25 8C11.25 7.59 11.59 7.25 12 7.25C12.41 7.25 12.75 7.59 12.75 8V13C12.75 13.41 12.41 13.75 12 13.75C11.59 13.75 11.25 13.41 11.25 13V8ZM12.92 16.38C12.87 16.51 12.8 16.61 12.71 16.71C12.61 16.8 12.5 16.87 12.38 16.92C12.26 16.97 12.13 17 12 17C11.87 17 11.74 16.97 11.62 16.92C11.5 16.87 11.39 16.8 11.29 16.71C11.2 16.61 11.13 16.51 11.08 16.38C11.03 16.26 11 16.13 11 16C11 15.87 11.03 15.74 11.08 15.62C11.13 15.5 11.2 15.39 11.29 15.29C11.39 15.2 11.5 15.13 11.62 15.08C11.86 14.98 12.14 14.98 12.38 15.08C12.5 15.13 12.61 15.2 12.71 15.29C12.8 15.39 12.87 15.5 12.92 15.62C12.97 15.74 13 15.87 13 16C13 16.13 12.97 16.26 12.92 16.38Z" fill="#555555"/>
            </svg>

            <span>{{ trans('product::products.variants.has_product_variant') }}</span>
        </div>

        <template v-else>
            <div class="form-group">
                <label for="price" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.price') }}
                    <span class="text-red">*</span>
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            @{{ defaultCurrencySymbol }}
                        </span>

                        <input type="number" min="0" name="price" step="0.1" id="price"
                            class="form-control" @wheel="$event.target.blur()" v-model="form.price">
                    </div>

                    <span class="help-block text-red" v-if="errors.has('price')" v-text="errors.get('price')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="special-price" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.special_price') }}
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            @{{ form.special_price_type === 'fixed' ? defaultCurrencySymbol : '%' }}
                        </span>

                        <input type="number" min="0" name="special_price" step="0.1" id="special-price"
                            class="form-control" @wheel="$event.target.blur()" v-model="form.special_price">
                    </div>

                    <span class="help-block text-red" v-if="errors.has('special_price')"
                        v-text="errors.get('special_price')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="special-price-type" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.special_price_type') }}
                </label>

                <div class="col-sm-9">
                    <select name="special_price_type" id="special-price-type" class="form-control custom-select-black"
                        v-model="form.special_price_type">
                        <option value="fixed">
                            {{ trans('product::products.form.special_price_types.fixed') }}
                        </option>

                        <option value="percent">
                            {{ trans('product::products.form.special_price_types.percent') }}
                        </option>
                    </select>

                    <span class="help-block text-red" v-if="errors.has('special_price_type')"
                        v-text="errors.get('special_price_type')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="special-price-start" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.special_price_start') }}
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>

                        <flat-pickr name="special_price_start" id="special-price-start" class="form-control"
                            :config="flatPickrConfig" v-model="form.special_price_start">
                        </flat-pickr>

                        <span
                            class="input-group-addon cursor-pointer"
                            v-if="form.special_price_start"
                            @click="removeDatePickerValue('special_price_start')"
                        >
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                    </div>

                    <span class="help-block text-red" v-if="errors.has('special_price_start')"
                        v-text="errors.get('special_price_start')"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="special-price-end" class="col-sm-3 control-label text-left">
                    {{ trans('product::attributes.special_price_end') }}
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>

                        <flat-pickr name="special_price_end" id="special-price-end" class="form-control"
                            :config="flatPickrConfig" v-model="form.special_price_end">
                        </flat-pickr>

                        <span
                            class="input-group-addon cursor-pointer"
                            v-if="form.special_price_end"
                            @click="removeDatePickerValue('special_price_end')"
                        >
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                    </div>

                    <span class="help-block text-red" v-if="errors.has('special_price_end')"
                        v-text="errors.get('special_price_end')"></span>
                </div>
            </div>
        </template>
    </div>
</template>
