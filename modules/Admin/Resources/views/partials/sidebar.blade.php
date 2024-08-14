<aside class="main-sidebar">
    <header class="main-header clearfix">
        <a class="logo" href="{{ route('admin.dashboard.index') }}">
            @if (is_null($logo))
                <img src="{{ asset('build/assets/sidebar-logo-ltr.svg') }}" alt="sidebar logo">
            @else
                <img src="{{ $logo }}" alt="sidebar logo">
            @endif
        </a>

        <a class="sidebar-logo-mini" href="{{ route('admin.dashboard.index') }}">
            @if (is_null($smallLogo))
                <img src="{{ asset('build/assets/sidebar-logo-mini.svg') }}" alt="sidebar logo mini">
            @else
                <img src="{{ $smallLogo }}" alt="sidebar logo mini">
            @endif
        </a>

        <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M15.0001 19.92L8.48009 13.4C7.71009 12.63 7.71009 11.37 8.48009 10.6L15.0001 4.07996" stroke="#292D32" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="150px" height="150px">
                <path d="M 3 9 A 1.0001 1.0001 0 1 0 3 11 L 47 11 A 1.0001 1.0001 0 1 0 47 9 L 3 9 z M 3 24 A 1.0001 1.0001 0 1 0 3 26 L 47 26 A 1.0001 1.0001 0 1 0 47 24 L 3 24 z M 3 39 A 1.0001 1.0001 0 1 0 3 41 L 47 41 A 1.0001 1.0001 0 1 0 47 39 L 3 39 z"/>
            </svg>
        </a>
    </header>
    <section class="sidebar">
        {!! $sidebar !!}
    </section>
</aside>
