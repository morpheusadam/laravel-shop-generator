<?php

namespace Modules\Slider\Providers;

use Modules\Slider\Admin\SliderTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;

class SliderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('sliders', SliderTabs::class);
    }
}
