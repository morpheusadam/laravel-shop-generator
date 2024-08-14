<form method="GET" action="{{ route('blog.search') }}" class="blog-post-search">
    <input type="text" name="query" placeholder="{{ trans('storefront::blog.blog_posts.search_blog_posts') }}">

    <button type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M22 22L20 20" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </button>
</form>

<div class="blog-categories">
    <h4 class="section-title">{{ trans('storefront::blog.blog_posts.categories') }}</h4>

    <ul class="blog-categories-list list-inline">
        @forelse ($blogCategories as $blogCategory)
            <li class="blog-categories-item d-flex align-items-center justify-content-between">
                <a href="{{ route('blog_category.blog_posts.index', ['category' => $blogCategory->id]) }}">
                    {{ $blogCategory->name }}
                </a>

                <span class="count">{{ $blogCategory->blog_posts_count }}</span>
            </li>
        @empty
            <li class="empty d-flex justify-content-center">{{ trans('storefront::blog.blog_posts.no_categories') }}</li>
        @endforelse
    </ul>
</div>

<div class="recent-blog-posts">
    <h4 class="section-title">{{ trans('storefront::blog.blog_posts.recent_posts') }}</h4>

    <div class="recent-blog-posts-content">
        @forelse ($recentBlogPosts as $recentBlogPost)
            <div class="recent-blog-post d-flex">
                <a href="{{ route('blog_posts.show', ['slug' => $recentBlogPost->slug]) }}" class="blog-post-thumb position-relative overflow-hidden">
                    @if (!$recentBlogPost->featured_image->path)
                        <div class="image-placeholder">
                            <img src="{{ asset('build/assets/image-placeholder.png') }}"
                                alt="Blog featured image" />
                        </div>
                    @else
                        <img src="{{ $recentBlogPost->featured_image->path }}" alt="Blog featured image" />
                    @endif
                </a>

                <div class="blog-post-info">
                    <h6 class="blog-post-title">
                        <a href="{{ route('blog_posts.show', ['slug' => $recentBlogPost->slug]) }}">
                            {{ $recentBlogPost->title }}
                        </a>
                    </h6>

                    <ul class="list-inline blog-post-meta d-flex">
                        <li class="d-flex align-items-center">
                            <i class="las la-calendar"></i>
                            {{ $recentBlogPost->created_at->format('d M, Y') }}
                        </li>
                    </ul>
                </div>
            </div>
        @empty
            <div class="recent-blog-post empty text-center">
                {{ trans('storefront::blog.blog_posts.no_recent_posts') }}
            </div>
        @endforelse
    </div>
</div>