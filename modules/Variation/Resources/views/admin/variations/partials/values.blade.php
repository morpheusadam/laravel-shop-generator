<div v-cloak class="row" v-if="!isEmptyVariationType">
    <div class="col-lg-2 col-sm-2">
        <h5>{{ trans('variation::variations.group.values') }}</h5>
    </div>

    <div class="col-lg-7 col-sm-10">
        <div class="variation-values clearfix">
            <div class="table-responsive">
                <table
                    class="options table table-bordered table-striped"
                    :class="form.type !== '' ? `type-${form.type}` : ''"
                >
                    <thead>
                        <tr>
                            <th></th>
                            <th>
                                {{ trans('variation::variations.form.label') }}
                                <span class="text-red">*</span>
                            </th>
                            <th v-if="form.type === 'color'">
                                {{ trans('variation::variations.form.color') }}
                                <span class="text-red">*</span>
                            </th>
                            <th v-else-if="form.type === 'image'">
                                {{ trans('variation::variations.form.image') }}
                                <span class="text-red">*</span>
                            </th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody
                        is="draggable"
                        tag="tbody"
                        handle=".drag-handle"
                        animation="150"
                        :list="form.values"
                        @end="updateColorThumbnails"
                    >
                        <tr v-for="(value, index) in form.values" class="option-row" :key="index">
                            <td class="text-center">
                                <span class="drag-handle">
                                    <i class="fa">&#xf142;</i>
                                    <i class="fa">&#xf142;</i>
                                </span>
                            </td>
                            <td>
                                <input
                                    type="text"
                                    :name="`values.${value.uid}.label`"
                                    :id="`values-${value.uid}-label`"
                                    class="form-control"
                                    @keyup.enter="addRowOnPressEnter($event, index)"
                                    v-model="value.label"
                                >

                                <span
                                    class="help-block text-red"
                                    v-if="errors.has(`values.${value.uid}.label`)"
                                    v-text="errors.get(`values.${value.uid}.label`)"
                                >
                                </span>
                            </td>
                            <td v-if="form.type === 'color'">
                                <div>
                                    <input
                                        type="text"
                                        :name="`values.${value.uid}.color`"
                                        :id="`values-${value.uid}-color`"
                                        class="form-control color-picker"
                                        v-model="value.color"
                                    >
                                </div>

                                <span
                                    class="help-block text-red"
                                    v-if="errors.has(`values.${value.uid}.color`)"
                                    v-text="errors.get(`values.${value.uid}.color`)"
                                >
                                </span>
                            </td>
                            <td v-else-if="form.type === 'image'">
                                <div class="d-flex">
                                    <div
                                        class="image-holder"
                                        @click="chooseImage(index, value.uid)"
                                    >
                                        <template v-if="value.image.id">
                                            <img :src="value.image.path" alt="variation image">
                                        </template>

                                        <img v-else src="{{ asset('build/assets/placeholder_image.png') }}" class="placeholder-image" alt="Placeholder image">
                                    </div>
                                </div>

                                <span
                                    class="help-block text-red"
                                    v-if="errors.has(`values.${value.uid}.image`)"
                                    v-text="errors.get(`values.${value.uid}.image`)"
                                >
                                </span>
                            </td>
                            <td class="text-center">
                                <button
                                    type="button"
                                    tabindex="-1"
                                    class="btn btn-default delete-row"
                                    @click="deleteRow(index, value.uid)"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-default" @click="addRow">
                {{ trans('variation::variations.form.add_row') }}
            </button>
        </div>
    </div>
</div>
