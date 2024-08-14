<div class="box">
    <div class="box-header">
        <h5>{{ trans('product::products.group.general') }}</h5>
    </div>

    <div class="box-body">
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.name') }}
                <span class="text-red">*</span>
            </label>

            <div class="col-sm-9">
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    v-model="form.name"

                    @if (request()->routeIs('admin.products.create'))
                        @change="setProductSlug($event.target.value)"
                    @endif
                >

                <span class="help-block text-red" v-if="errors.has('name')" v-text="errors.get('name')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 control-label text-left" @click="focusEditor">
                {{ trans('product::attributes.description') }}
                <span class="text-red">*</span>
            </label>

            <div class="col-sm-9">
                <textarea
                    name="description"
                    id="description"
                    class="form-control wysiwyg"
                    v-model="form.description"
                >
                </textarea>

                <span class="help-block text-red" v-if="errors.has('description')" v-text="errors.get('description')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="brand-id" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.brand_id') }}
            </label>

            <div class="col-sm-5">
                <select name="brand_id" id="brand-id" class="form-control custom-select-black" v-model="form.brand_id">
                    @foreach ($brands as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>

                <span class="help-block text-red" v-if="errors.has('brand_id')" v-text="errors.get('brand_id')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="categories" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.categories') }}
            </label>

            <div class="col-sm-5">
                <selectize
                    name="categories"
                    id="categories"
                    :settings="categoriesSelectizeConfig"
                    v-model="form.categories"
                    multiple
                >
                    @foreach ($categories as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </selectize>

                <span class="help-block text-red" v-if="errors.has('categories')" v-text="errors.get('categories')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="tax-class-id" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.tax_class_id') }}
            </label>

            <div class="col-sm-5">
                <select name="tax_class_id" id="tax-class-id" class="form-control custom-select-black" v-model="form.tax_class_id">
                    @foreach ($taxClasses as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>

                <span class="help-block text-red" v-if="errors.has('tax_class_id')" v-text="errors.get('tax_class_id')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="tags" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.tags') }}
            </label>

            <div class="col-sm-5">
                <selectize
                    name="tags"
                    id="tags"
                    :settings="selectizeConfig"
                    v-model="form.tags"
                    multiple
                >
                    @foreach ($tags as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </selectize>

                <span class="help-block text-red" v-if="errors.has('tags')" v-text="errors.get('tags')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="is_virtual" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.is_virtual') }}
            </label>

            <div class="col-sm-5">
                <div class="switch">
                    <input
                        type="checkbox"
                        name="is_virtual"
                        id="is-virtual"
                        v-model="form.is_virtual"
                    >

                    <label for="is-virtual">
                        {{ trans('product::products.form.the_product_won\'t_be_shipped') }}
                    </label>
                </div>

                <span class="help-block text-red" v-if="errors.has('is_virtual')" v-text="errors.get('is_virtual')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="is-active" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.is_active') }}
            </label>

            <div class="col-sm-9">
                <div class="switch">
                    <input
                        type="checkbox"
                        name="is_active"
                        id="is-active"
                        v-model="form.is_active"
                    >

                    <label for="is-active">
                        {{ trans('product::products.form.enable_the_product') }}
                    </label>

                    <span class="help-block text-red" v-if="errors.has('is_active')" v-text="errors.get('is_active')"></span>
                </div>
            </div>
        </div>
    </div>
</div>
