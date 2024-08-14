<?php

namespace Modules\FlashSale\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\FlashSale\Admin\FlashSaleTabs;

class FlashSaleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('flash_sales', FlashSaleTabs::class);
    }
}
