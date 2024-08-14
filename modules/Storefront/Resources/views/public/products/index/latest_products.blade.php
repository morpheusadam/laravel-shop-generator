@if ($latestProducts->isNotEmpty())
    <div class="vertical-products">
        <div class="vertical-products-header">
            <h4 class="section-title">{{ trans('storefront::products.latest_products') }}</h4>
        </div>

        <div class="vertical-products-slider" ref="latestProducts">
            @foreach ($latestProducts->chunk(5) as $latestProductChunks)
                <div class="vertical-products-slide">
                    @foreach ($latestProductChunks as $latestProduct)
                        <product-card-vertical :product="{{ json_encode($latestProduct) }}"></product-card-vertical>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif
