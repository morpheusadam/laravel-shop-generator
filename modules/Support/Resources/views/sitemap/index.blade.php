@extends('storefront::public.layout')

@push('meta')
    <meta name="title" content="Sitemap">
    <meta name="description" content="HTML Sitemap">
@endpush

@section('content')
    <div class="container">
        <div class="sitemap-parent">
            @foreach ($sitemapIndices as $title => $sitemapIndex)
                <div class="row">
                    <div class="col-md-4">
                        <h5>{{ $title }}</h5>
                    </div>

                    <div class="col-md-14">
                        <ul class="sitemap-items">
                            @foreach ($sitemapIndex as $sitemap)
                                <li>
                                    <a href="{{ $sitemap['href'] }}">{{ $sitemap['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('globals')
    @vite([
        'modules/Support/Resources/assets/public/sass/main.scss',
    ])
@endpush
