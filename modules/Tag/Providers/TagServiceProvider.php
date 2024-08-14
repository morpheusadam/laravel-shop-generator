<?php

namespace Modules\Tag\Providers;

use Modules\Tag\Admin\TagTabs;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;

class TagServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('tags', TagTabs::class);
    }
}
