<?php

namespace Modules\Tax\Providers;

use Modules\Tax\Admin\TaxTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;

class TaxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('tax_classes', TaxTabs::class);
    }
}
