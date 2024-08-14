<div class="bulk-edit-variants overflow-hidden">
    <div class="form-group">
        <label for="variation-values-list" class="col-sm-3 control-label text-left">
            {{ trans('product::products.form.variants.bulk_edit') }}
        </label>

        <div class="col-sm-5">
            <select
                name="variation_values_list"
                id="variation-values-list"
                class="form-control custom-select-black"
                @change="changeBulkEditVariantsUid($event.target.value)"
                v-model="bulkEditVariantsUid"
            >
                <option value="">{{ trans('admin::admin.form.please_select') }}</option>
                <option value="all">{{ trans('product::products.form.variants.all_variants') }}</option>

                <template v-for="(variation, index) in form.variations">
                    <template v-for="(value, valueIndex) in variation.values">
                        <option v-if="variation.type !== '' && Boolean(value.label)" :key="value.uid" :value="value.uid">
                            @{{ value.label }}
                        </option>
                    </template>
                </template>
            </select>
        </div>
    </div>

    <div v-if="hasBulkEditVariantsUid" class="form-group">
        <label for="bulk-edit-variants-field-type" class="col-sm-3 control-label text-left">
            {{ trans('product::products.form.variants.field_type') }}
        </label>

        <div class="col-sm-5">
            <select
                name="bulk_edit_variants_field_type"
                id="bulk-edit-variants-field-type"
                class="form-control custom-select-black"
                @change="changeBulkEditVariantsField($event.target.value)"
                v-model="bulkEditVariantsField"
            >
                <option value="">{{ trans('admin::admin.form.please_select') }}</option>
                <option value="is_active">{{ trans('product::products.form.variants.is_active') }}</option>
                <option value="media">{{ trans('product::products.form.variants.media') }}</option>
                <option value="sku">{{ trans('product::products.form.variants.sku') }}</option>
                <option value="price">{{ trans('product::products.form.variants.price') }}</option>
                <option value="special_price">{{ trans('product::products.form.variants.special_price') }}</option>
                <option value="manage_stock">{{ trans('product::products.form.variants.manage_stock') }}</option>
                <option value="in_stock">{{ trans('product::products.form.variants.in_stock') }}</option>
            </select>
        </div>
    </div>

    <template v-if="hasBulkEditVariantsUid && hasBulkEditVariantsField">
        <div v-if="bulkEditVariantsField === 'is_active'" class="form-group">
            <label for="bulk-edit-variants-is-active" class="col-sm-3 control-label text-left">
                {{ trans('product::products.form.variants.is_active') }}
            </label>

            <div class="col-sm-5">
                <div class="checkbox">
                    <input
                        type="checkbox"
                        name="bulk_edit_variants_is_active"
                        id="bulk-edit-variants-is-active"
                        v-model="bulkEditVariants.is_active"
                    >

                    <label for="bulk-edit-variants-is-active">
                        {{ trans('product::products.form.variants.enable_the_variants') }}
                    </label>
                </div>
            </div>
        </div>

        <div v-else-if="bulkEditVariantsField === 'media'" class="form-group">
            <label class="col-sm-3 control-label text-left">
                {{ trans('product::products.form.variants.media') }}
            </label>

            <div class="col-sm-5">
                <draggable
                    animation="200"
                    class="product-media-grid"
                    force-fallback="true"
                    handle=".handle"
                    :move="preventLastSlideDrag"
                    :list="bulkEditVariants.media"
                >
                    <div class="media-grid-item handle" v-for="(media, index) in bulkEditVariants.media" :key="index">
                        <div class="image-holder">
                            <img :src="media.path" alt="product variants media">

                            <button type="button" class="btn remove-image" @click="removeBulkEditVariantsMedia(index)"></button>
                        </div>
                    </div>

                    <div class="media-grid-item media-picker disabled" @click="addBulkEditVariantsMedia">
                        <div class="image-holder">
                            <img src="{{ asset('build/assets/placeholder_image.png') }}" class="placeholder-image" alt="Placeholder image">
                        </div>
                    </div>
                </draggable>
            </div>
        </div>

        <div v-else-if="bulkEditVariantsField === 'sku'" class="form-group">
            <label for="bulk-edit-variants-sku" class="col-sm-3 control-label text-left">
                {{ trans('product::products.form.variants.sku') }}
            </label>

            <div class="col-sm-5">
                <input
                    type="text"
                    name="bulk_edit_variants_sku"
                    id="bulk-edit-variants-sku"
                    class="form-control"
                    v-model="bulkEditVariants.sku"
                >
            </div>
        </div>

        <div v-else-if="bulkEditVariantsField === 'price'" class="form-group">
            <label for="bulk-edit-variants-price" class="col-sm-3 control-label text-left">
                {{ trans('product::products.form.variants.price') }}
            </label>

            <div class="col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon">
                        @{{ defaultCurrencySymbol }}
                    </span>

                    <input
                        type="number"
                        name="bulk_edit_variants_price"
                        min="0"
                        step="0.1"
                        id="bulk-edit-variants-price"
                        class="form-control"
                        @wheel="$event.target.blur()"
                        v-model.number="bulkEditVariants.price"
                    >
                </div>
            </div>
        </div>

        <template v-else-if="bulkEditVariantsField === 'special_price'">
            <div class="form-group">
                <label for="bulk-edit-variants-special-price" class="col-sm-3 control-label text-left">
                    {{ trans('product::products.form.variants.special_price') }}
                </label>

                <div class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            @{{ bulkEditVariants.special_price_type === 'fixed' ? defaultCurrencySymbol : '%' }}
                        </span>

                        <input
                            type="number"
                            name="bulk_edit_variants_special_price"
                            min="0"
                            step="0.1"
                            id="bulk-edit-variants-special-price"
                            class="form-control"
                            @wheel="$event.target.blur()"
                            v-model="bulkEditVariants.special_price"
                        >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="bulk-edit-variants-special-price-type" class="col-sm-3 control-label text-left">
                    {{ trans('product::products.form.variants.special_price_type') }}
                </label>

                <div class="col-sm-5">
                    <select
                        name="bulk_edit_variants_special_price_type"
                        id="bulk-edit-variants-special-price-type"
                        class="form-control custom-select-black"
                        v-model="bulkEditVariants.special_price_type"
                    >
                        <option value="fixed">
                            {{ trans('product::products.form.variants.special_price_types.fixed') }}
                        </option>

                        <option value="percent">
                            {{ trans('product::products.form.variants.special_price_types.percent') }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="bulk-edit-variants-special-price-start" class="col-sm-3 control-label text-left">
                    {{ trans('product::products.form.variants.special_price_start') }}
                </label>

                <div class="col-sm-5">
                    <flat-pickr
                        name="bulk_edit_variants_special_price_start"
                        id="bulk-edit-variants-special-price-start"
                        class="form-control"
                        :config="flatPickrConfig"
                        v-model="bulkEditVariants.special_price_start"
                    >
                    </flat-pickr>
                </div>
            </div>

            <div class="form-group">
                <label for="bulk-edit-variants-special-price-end" class="col-sm-3 control-label text-left">
                    {{ trans('product::products.form.variants.special_price_end') }}
                </label>

                <div class="col-sm-5">
                    <flat-pickr
                        name="bulk_edit_variants_special_price_end"
                        id="bulk-edit-variants-special-price-end"
                        class="form-control"
                        :config="flatPickrConfig"
                        v-model="bulkEditVariants.special_price_end"
                    >
                    </flat-pickr>
                </div>
            </div>
        </template>

        <template v-else-if="bulkEditVariantsField === 'manage_stock'">
            <div class="form-group">
                <label for="bulk-edit-variants-manage-stock" class="col-sm-3 control-label text-left">
                    {{ trans('product::products.form.variants.manage_stock') }}
                </label>

                <div class="col-sm-5">
                    <select
                        name="bulk_edit_variants_manage_stock`"
                        id="bulk-edit-variants-manage-stock"
                        class="form-control custom-select-black"
                        @change="focusField({
                            selector: '#bulk-edit-variants-qty'
                        })"
                        v-model="bulkEditVariants.manage_stock"
                    >
                        <option value="0">
                            {{ trans('product::products.form.variants.manage_stock_states.0') }}
                        </option>

                        <option value="1">
                            {{ trans('product::products.form.variants.manage_stock_states.1') }}
                        </option>
                    </select>
                </div>
            </div>

            <div v-if="bulkEditVariants.manage_stock == 1" class="form-group">
                <label for="bulk-edit-variants-qty" class="col-sm-3 control-label text-left">
                    {{ trans('product::products.form.variants.qty') }}
                </label>

                <div class="col-sm-5">
                    <input
                        type="number"
                        name="bulk_edit_variants_qty"
                        min="0"
                        step="1"
                        id="bulk-edit-variants-qty"
                        class="form-control"
                        @wheel="$event.target.blur()"
                        v-model.number="bulkEditVariants.qty"
                    >
                </div>
            </div>
        </template>

        <div v-else-if="bulkEditVariantsField === 'in_stock'" class="form-group">
            <label for="bulk-edit-variants-in-stock`" class="col-sm-3 control-label text-left">
                {{ trans('product::products.form.variants.in_stock') }}
            </label>

            <div class="col-sm-5">
                <select
                    name="bulk_edit_variants_in_stock`"
                    id="bulk-edit-variants-in-stock`"
                    class="form-control custom-select-black"
                    v-model="bulkEditVariants.in_stock"
                >
                    <option value="0">
                        {{ trans('product::products.form.variants.stock_availability_states.0') }}
                    </option>

                    <option value="1">
                        {{ trans('product::products.form.variants.stock_availability_states.1') }}
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-5 col-sm-offset-3">
                <button type="button" class="btn btn-default" @click="bulkUpdateVariants">
                    {{ trans('product::products.variants.apply') }}
                </button>
            </div>
        </div>
    </template>
</div>
