<div class="row" :class="{ 'has-variation-type': !isEmptyVariationType }">
    <div class="col-lg-2 col-sm-2">
        <h5>{{ trans('variation::variations.group.general') }}</h5>
    </div>

    <div class="col-lg-7 col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">
                        {{ trans('variation::attributes.name') }}
                        <span class="text-red">*</span>
                    </label>

                    <input type="text" name="name" id="name" class="form-control" v-model="form.name">

                    <span class="help-block text-red" v-if="errors.has('name')" v-text="errors.get('name')"></span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="type">
                        {{ trans('variation::attributes.type') }}
                        <span class="text-red">*</span>
                    </label>

                    <select
                        name="type"
                        id="type"
                        class="form-control custom-select-black"
                        @change="changeVariationType($event.target.value)"
                        v-model="form.type"
                    >
                        <option value="">
                            {{ trans('variation::variations.form.variation_types.please_select') }}
                        </option>

                        <option value="text">
                            {{ trans('variation::variations.form.variation_types.text') }}
                        </option>

                        <option value="color">
                            {{ trans('variation::variations.form.variation_types.color') }}
                        </option>

                        <option value="image">
                            {{ trans('variation::variations.form.variation_types.image') }}
                        </option>
                    </select>

                    <span class="help-block text-red" v-if="errors.has('type')" v-text="errors.get('type')"></span>
                </div>
            </div>
        </div>
    </div>
</div>
