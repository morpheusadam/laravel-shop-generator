<?php

namespace Modules\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Support\Console\SitemapGenerateCommand;

class SitemapServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (!config('app.installed')) {
            return;
        }

        if ($this->app->runningInConsole()) {
            $this->commands(SitemapGenerateCommand::class);
        }
    }
}
