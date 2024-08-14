<aside class="sidebar-menu-wrap">
    <div class="sidebar-menu-close">
        <i class="las la-times"></i>
    </div>

    <div class="sidebar-menu-curve-background">
        <ul class="nav nav-tabs sidebar-menu-tab" role="tablist">
            <li class="nav-item" role="presentation"> 
                <a class="nav-link active" data-toggle="tab" href="#category-menu">
                    {{ trans('storefront::layout.categories') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" data-toggle="tab" href="#main-menu">
                    {{ trans('storefront::layout.menu') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" data-toggle="tab" href="#more-menu">
                    {{ trans('storefront::layout.more') }}
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content custom-scrollbar">
        <div id="category-menu" class="tab-pane active">
            @include('storefront::public.layout.sidebar_menu.menu', ['type' => 'category_menu', 'menu' => $categoryMenu])
        </div>

        <div id="main-menu" class="tab-pane">
            @include('storefront::public.layout.sidebar_menu.menu', ['type' => 'primary_menu', 'menu' => $primaryMenu])
        </div>

        <div id="more-menu" class="tab-pane">
            @include('storefront::public.layout.sidebar_menu.more_menu')
        </div>
    </div>
</aside>
