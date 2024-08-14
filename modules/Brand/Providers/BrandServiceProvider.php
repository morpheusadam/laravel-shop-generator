<?php

namespace Modules\Brand\Providers;

use Modules\Brand\Admin\BrandTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('brands', BrandTabs::class);
    }
}
