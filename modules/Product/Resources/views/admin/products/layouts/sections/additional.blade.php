<template v-else-if="section === 'additional'">
    <div class="box-header">
        <h5>{{ trans('product::products.group.additional') }}</h5>

        <div class="drag-handle">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
    </div>

    <div class="box-body">
        <div class="form-group">
            <label for="short-description" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.short_description') }}
            </label>

            <div class="col-sm-9">
                <textarea name="short_description" rows="6" cols="10" id="short-description" class="form-control" v-model="form.short_description"></textarea>

                <span class="help-block text-red" v-if="errors.has('short_description')" v-text="errors.get('short_description')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="new-from" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.new_from') }}
            </label>

            <div class="col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                    </span>

                    <flat-pickr
                        name="new_from"
                        id="new-from"
                        class="form-control"
                        :config="flatPickrConfig"
                        v-model="form.new_from"
                    >
                    </flat-pickr>

                    <span
                        class="input-group-addon cursor-pointer"
                        v-if="form.new_from"
                        @click="removeDatePickerValue('new_from')"
                    >
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </span>
                </div>

                <span class="help-block text-red" v-if="errors.has('new_from')" v-text="errors.get('new_from')"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="new-to" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.new_to') }}
            </label>

            <div class="col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                    </span>

                    <flat-pickr
                        name="new_to"
                        id="new-to"
                        class="form-control"
                        :config="flatPickrConfig"
                        v-model="form.new_to"
                    >
                    </flat-pickr>

                    <span
                        class="input-group-addon cursor-pointer"
                        v-if="form.new_to"
                        @click="removeDatePickerValue('new_to')"
                    >
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </span>
                </div>

                <span class="help-block text-red" v-if="errors.has('new_to')" v-text="errors.get('new_to')"></span>
            </div>
        </div>
    </div>
</template>
