<template v-if="section === 'attributes'">
    <div class="box-header">
        <h5>{{ trans('product::products.group.attributes') }}</h5>

        <div class="drag-handle">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
    </div>

    <div class="box-body">
        <div id="product-attributes-wrapper">
            <div class="table-responsive">
                <table class="options table table-bordered">
                    <thead class="hidden-xs">
                        <tr>
                            <th></th>
                            <th>{{ trans('product::products.attributes.attribute') }}</th>
                            <th>{{ trans('product::products.attributes.values') }}</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody
                        animation="150"
                        handle=".drag-handle"
                        is="draggable"
                        tag="tbody"
                        :list="form.attributes"
                    >
                        <tr v-for="(attribute, index) in form.attributes" :key="index">
                            <td class="text-center">
                                <span class="drag-handle">
                                    <i class="fa">&#xf142;</i>
                                    <i class="fa">&#xf142;</i>
                                </span>
                            </td>

                            <td>
                                <div class="form-group">
                                    <label :for="`attributes-${attribute.uid}-attribute-id`" class="visible-xs">
                                        {{ trans('product::products.attributes.attribute') }}
                                    </label>

                                    <select
                                        :name="`attributes.${attribute.uid}.attribute_id`"
                                        :id="`attributes-${attribute.uid}-attribute-id`"
                                        class="form-control attribute custom-select-black"
                                        @change="focusAttributeValueField(index)"
                                        v-model.number="attribute.attribute_id"
                                    >
                                        <option value="">{{ trans('admin::admin.form.please_select') }}</option>

                                        @foreach ($attributeSets as $attributeSet)
                                            <optgroup label="{{ $attributeSet->name }}">
                                                @foreach ($attributeSet->attributes as $attribute)
                                                    <option value="{{ $attribute->id }}">
                                                        {{ $attribute->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>

                                    <span
                                        class="help-block text-red"
                                        v-if="errors.has(`attributes.${attribute.uid}.attribute_id`)"
                                        v-text="errors.get(`attributes.${attribute.uid}.attribute_id`)"
                                    >
                                    </span>
                                </div>
                            </td>

                            <td>
                                <div class="form-group">
                                    <label :for="`attributes-${attribute.uid}-values`" class="visible-xs">
                                        {{ trans('product::products.attributes.values') }}
                                    </label>

                                    <selectize
                                        :name="`attributes.${attribute.uid}.values`"
                                        :id="`attributes-${attribute.uid}-values`"
                                        :settings="selectizeConfig"
                                        @input="clearValuesError({ name: 'attributes', uid: attribute.uid })"
                                        v-model="attribute.values"
                                        multiple
                                        ref="attributeValues"
                                    >
                                        <option
                                            v-for="(value, valueIndex) in getAttributeValuesById(attribute.attribute_id)"
                                            :key="valueIndex"
                                            :value="value.id"
                                        >
                                            @{{ value.value }}
                                        </option>
                                    </selectize>

                                    <span
                                        class="help-block text-red"
                                        v-if="errors.has(`attributes.${attribute.uid}.values`)"
                                        v-text="errors.get(`attributes.${attribute.uid}.values`)"
                                    >
                                    </span>
                                </div>
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-default delete-row" @click="deleteAttribute(index, attribute.uid)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-default" @click="addAttribute">
                {{ trans('product::products.attributes.add_attribute') }}
            </button>
        </div>
    </div>
</template>
