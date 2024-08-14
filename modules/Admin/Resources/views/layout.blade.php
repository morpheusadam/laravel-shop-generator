<!DOCTYPE html>
<html lang="{{ locale() }}">
    <head>
        <base href="{{ url('/') }}">
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @yield('title') - {{ setting('store_name') }} {{trans('admin::admin.admin')}}
        </title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

        <script src="{{ v(asset('build/assets/jquery.min.js')) }}"></script>
        <script src="{{ v(asset('build/assets/selectize.min.js')) }}"></script>

        @vite([
            'modules/Admin/Resources/assets/sass/main.scss',
            'modules/Admin/Resources/assets/js/main.js',
            'modules/Admin/Resources/assets/js/app.js'
        ])

        @stack('styles')

        @include('admin::partials.globals')
    </head>

    <body class="skin-blue sidebar-mini offcanvas clearfix {{ is_rtl() ? 'rtl' : 'ltr' }}" dir>
        <div class="left-side"></div>

        @include('admin::partials.sidebar')

        <div class="wrapper">
            <div class="content-wrapper">
                @include('admin::partials.top_nav')

                <section class="content-header clearfix">
                    @yield('content_header')
                </section>

                <section class="content">
                    @include('admin::partials.notification')

                    @yield('content')
                </section>

                <div id="notification-toast"></div>
            </div>
        </div>

        @include('admin::partials.footer')
        @include('admin::partials.confirmation_modal')

        @stack('scripts')
    </body>
</html>
