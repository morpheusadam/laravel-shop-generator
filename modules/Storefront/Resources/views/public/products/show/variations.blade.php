@foreach ($product->variations as $variation)
    <div class="variant-custom-selection">
        <div class="row">
            <div class="col-lg-18">
                <label class="d-flex">
                    {{ $variation->name }}:
                    <span class="d-flex variation-label" v-text="activeVariationValues['{{ $variation->uid }}']"></span>
                </label>
            </div>

            <div class="col-lg-18">               
                <ul class="list-inline form-custom-radio custom-selection">
                    @foreach ($variation->values as $value)
                        <li
                            :title="
                                isVariationValueEnabled('{{ $variation->uid }}', {{ $loop->parent->index }}, '{{ $value->uid }}') &&
                                !isActiveVariationValue('{{ $variation->uid }}', '{{ $value->uid }}') ?
                                '{{ trans('storefront::product.click_to_select') }} {{ $value->label }}' :
                                ''
                            "
                            class="
                                {{ $variation->type === 'color' ? 'variation-color' : '' }}
                                {{ $variation->type === 'image' ? 'variation-image' : '' }}
                            "
                            :class="{
                                active: isActiveVariationValue('{{ $variation->uid }}', '{{ $value->uid }}'),
                                disabled: !isVariationValueEnabled('{{ $variation->uid }}', {{ $loop->parent->index }}, '{{ $value->uid }}')

                            }"
                            @mouseenter="setVariationValueLabel({{ $loop->parent->index }}, {{ $loop->index }})"
                            @mouseleave="setActiveVariationValueLabel({{ $loop->parent->index }})"
                            @click="syncVariationValue(
                                '{{ $variation->uid }}',
                                {{ $loop->parent->index }},
                                '{{ $value->uid }}',
                                {{ $loop->index }}
                            )"
                        >
                            @if ($variation->type === 'text')
                                {{ $value->label }}
                            @elseif ($variation->type === 'color')
                                <div style="background-color: {{ $value->color }};"></div>
                            @elseif ($variation->type === 'image')
                                <img src="{{ $value->image->path }}" alt="{{ $value->label }}">
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endforeach
