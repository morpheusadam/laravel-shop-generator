<nav class="navbar navbar-expand-sm">
    <ul class="navbar-nav mega-menu horizontal-megamenu">
        @foreach ($primaryMenu->menus() as $menu)
            @include('storefront::public.layout.navigation.menu', ['type' => 'primary_menu'])
        @endforeach
    </ul>
</nav>
