<div class="product-gallery position-relative align-self-start">
    <div class="product-gallery-preview-wrap position-relative overflow-hidden">
        <div class="product-gallery-preview">
            @if ($product->media->isNotEmpty())
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
            @else
                <div class="gallery-preview-slide">
                    <div class="gallery-preview-item">
                        <img src="{{ asset('build/assets/image-placeholder.png') }}" data-zoom="{{ asset('build/assets/image-placeholder.png') }}" alt="{{ $product->name }}" class="image-placeholder">
                    </div>

                    <a href="{{ asset('build/assets/image-placeholder.png') }}" data-gallery="product-gallery-preview" class="gallery-view-icon glightbox">
                        <i class="las la-search-plus"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="product-gallery-thumbnail" v-cloak>
        @if ($product->media->isNotEmpty())
            @foreach ($product->media as $media)
                <div class="gallery-thumbnail-slide">
                    <div class="gallery-thumbnail-item">
                        <img src="{{ $media->path }}" alt="{{ $product->name }}">
                    </div>
                </div>
            @endforeach
        @else
            <div class="gallery-thumbnail-slide">
                <div class="gallery-thumbnail-item">
                    <img src="{{ asset('build/assets/image-placeholder.png') }}" alt="{{ $product->name }}" class="image-placeholder">
                </div>
            </div>
        @endif
    </div>
</div>
