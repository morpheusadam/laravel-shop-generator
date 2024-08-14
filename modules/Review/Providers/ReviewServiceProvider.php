<?php

namespace Modules\Review\Providers;

use Modules\Review\Admin\ReviewTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;

class ReviewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('reviews', ReviewTabs::class);
    }
}
