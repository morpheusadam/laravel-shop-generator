<template v-else-if="section === 'linked_products'">
    <div class="box-header">
        <h5>{{ trans('product::products.group.linked_products') }}</h5>

        <div class="drag-handle">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
    </div>

    <div class="box-body">
        <div class="form-group">
            <label for="up-sells" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.up_sells') }}
            </label>

            <div class="col-sm-9">
                <selectize
                    name="up_sells"
                    id="up-sells"
                    :settings="searchableSelectizeConfig"
                    v-model="form.up_sells"
                    multiple
                >
                    @foreach ($product->upSellProducts as $upSellProduct)
                        <option value="{{ $upSellProduct->id }}">{{ $upSellProduct->name }}</option>
                    @endforeach
                </selectize>
            </div>
        </div>

        <div class="form-group">
            <label for="cross-sells" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.cross_sells') }}
            </label>

            <div class="col-sm-9">
                <selectize
                    name="cross_sells"
                    id="cross-sells"
                    :settings="searchableSelectizeConfig"
                    v-model="form.cross_sells"
                    multiple
                >
                    @foreach ($product->crossSellProducts as $crossSellProduct)
                        <option value="{{ $crossSellProduct->id }}">{{ $crossSellProduct->name }}</option>
                    @endforeach
                </selectize>
            </div>
        </div>

        <div class="form-group">
            <label for="related-products" class="col-sm-3 control-label text-left">
                {{ trans('product::attributes.related_products') }}
            </label>

            <div class="col-sm-9">
                <selectize
                    name="related_products"
                    id="related-products"
                    :settings="searchableSelectizeConfig"
                    v-model="form.related_products"
                    multiple
                >
                    @foreach ($product->relatedProducts as $relatedProduct)
                        <option value="{{ $relatedProduct->id }}">{{ $relatedProduct->name }}</option>
                    @endforeach
                </selectize>
            </div>
        </div>
    </div>
</template>
