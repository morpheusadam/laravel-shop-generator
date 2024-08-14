<?php

namespace Modules\Menu\Providers;

use Modules\Menu\Admin\MenuItemTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('menu_items', MenuItemTabs::class);
    }
}
