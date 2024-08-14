@extends('storefront::public.layout')

@section('title', trans('storefront::blog.blog_posts.blog_posts'))

@section('content')
    <section class="all-blog-posts-wrap">
        <div class="container">
            <div class="row">
                <div class="col-xl-14 col-lg-12 order-1 order-lg-0">
                    <h4 class="all-blog-posts-title">
                        {{ $indexTitle }}
                    </h4>

                    <div class="all-blog-posts d-flex flex-column">
                        <div class="row">
                            <div class="blog-posts d-flex flex-wrap flex-grow-1">
                                @forelse ($blogPosts as $blogPost)
                                    <div class="blog-post-card">
                                        <div class="blog-post">
                                            <a href="{{ route('blog_posts.show', ['slug' => $blogPost->slug]) }}" class="blog-post-featured-image overflow-hidden">
                                                @if (!$blogPost->featured_image->path)
                                                    <div class="image-placeholder">
                                                        <img src="{{ asset('build/assets/image-placeholder.png') }}"
                                                            alt="Blog featured image" />
                                                    </div>
                                                @else
                                                    <img src="{{ $blogPost->featured_image->path }}" alt="Blog featured image" />
                                                @endif
                                            </a>

                                            <div class="blog-post-body">
                                                <ul class="list-inline blog-post-meta">
                                                    <li class="d-flex align-items-center">
                                                        <i class="las la-user"></i>
                                                        {{ $blogPost->user_name }}
                                                    </li>

                                                    <li class="d-flex align-items-center">
                                                        <i class="las la-calendar"></i>
                                                        {{ $blogPost->created_at->format('d M, Y') }}
                                                    </li>
                                                </ul>

                                                <h3 class="blog-post-title">
                                                    <a href="{{ route('blog_posts.show', ['slug' => $blogPost->slug]) }}">{{ $blogPost->title }}</a>
                                                </h3>

                                                <p class="blog-post-short-description">{{ $blogPost->short_description }}</p>

                                                <a href="{{ route('blog_posts.show', ['slug' => $blogPost->slug]) }}" class="blog-post-read-more">
                                                    {{ trans('storefront::blog.blog_posts.read_more') }}
                                                    <i class="las la-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-message">
                                        @include('storefront::public.products.index.empty_results_logo')

                                        <h2>{{ trans('storefront::blog.blog_posts.no_blog_post_found') }}</h2>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{ $blogPosts->links() }}
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 order-0 order-lg-1 mb-4 mb-lg-0">
                    @include('storefront::public.blogs.posts.layouts.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

@push('globals')
    @vite([
        'modules/Storefront/Resources/assets/public/sass/pages/_blog-post.scss',
    ])
@endPush
