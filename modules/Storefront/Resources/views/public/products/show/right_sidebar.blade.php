<aside class="right-sidebar">
    <div class="feature-list">
        @foreach ($features as $feature)
            <div class="single-feature">
                <div class="feature-icon">
                    <i class="{{ $feature->icon }}"></i>
                </div>

                <div class="feature-details">
                    <h6>{{ $feature->title }}</h6>
                    <span>{{ $feature->subtitle }}</span>
                </div>
            </div>
        @endforeach
    </div>
</aside>
