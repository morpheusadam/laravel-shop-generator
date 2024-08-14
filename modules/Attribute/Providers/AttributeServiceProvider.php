<?php

namespace Modules\Attribute\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\Attribute\Admin\AttributeTabs;
use Modules\Attribute\Admin\AttributeSetTabs;


class AttributeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('attributes', AttributeTabs::class);
        TabManager::register('attribute_sets', AttributeSetTabs::class);
    }
}
