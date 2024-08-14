<div class="product-gallery position-relative align-self-start">
    <div
        class="product-gallery-preview-wrap position-relative overflow-hidden"
        :class="{ 'visible-variation-image': hasAnyVariationImage }"
    >
        <img v-cloak v-if="hasAnyVariationImage" :src="variationImagePath" class="variation-image" alt="{{ $product->name }}">

        <div class="product-gallery-preview">
            @if ($product->media->isEmpty() && $product->variant->media->isEmpty())
                <div class="gallery-preview-slide">
                    <div class="gallery-preview-item">
                        <img src="{{ asset('build/assets/image-placeholder.png') }}" data-zoom="{{ asset('build/assets/image-placeholder.png') }}" alt="{{ $product->name }}" class="image-placeholder">
                    </div>

                    <a href="{{ asset('build/assets/image-placeholder.png') }}" data-gallery="product-gallery-preview" class="gallery-view-icon glightbox">
                        <i class="las la-search-plus"></i>
                    </a>
                </div>
            @else
                @foreach ($product->variant->media as $media)
                    <div class="gallery-preview-slide">
                        <div class="gallery-preview-item">
                            <img src="{{ $media->path }}" data-zoom="{{ $media->path }}" alt="{{ $product->name }}">
                        </div>

                        <a href="{{ $media->path }}" data-gallery="product-gallery-preview" class="gallery-view-icon glightbox">
                            <i class="las la-search-plus"></i>
                        </a>
                    </div>
                @endforeach

                @foreach ($product->media as $media)
                    <div class="gallery-preview-slide">
                        <div class="gallery-preview-item">
                            <img src="{{ $media->path }}" data-zoom="{{ $media->path }}" alt="{{ $product->name }}">
                        </div>

                        <a href="{{ $media->path }}" data-gallery="product-gallery-preview" class="gallery-view-icon glightbox">
                            <i class="las la-search-plus"></i>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="product-gallery-thumbnail" v-cloak>
        @if ($product->media->isEmpty() && $product->variant->media->isEmpty())
            <div class="gallery-thumbnail-slide">
                <div class="gallery-thumbnail-item">
                    <img src="{{ asset('build/assets/image-placeholder.png') }}" alt="{{ $product->name }}" class="image-placeholder">
                </div>
            </div>
        @else
            @foreach ($product->variant->media as $media)
                <div class="gallery-thumbnail-slide">
                    <div class="gallery-thumbnail-item">
                        <img src="{{ $media->path }}" alt="{{ $product->name }}">
                    </div>
                </div>
            @endforeach

            @foreach ($product->media as $media)
                <div class="gallery-thumbnail-slide">
                    <div class="gallery-thumbnail-item">
                        <img src="{{ $media->path }}" alt="{{ $product->name }}">
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
