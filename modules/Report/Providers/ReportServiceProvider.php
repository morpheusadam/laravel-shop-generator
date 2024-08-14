<?php

namespace Modules\Report\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('report::admin.reports.*', function ($view) {
            $view->with('request', $this->app['request']);
        });
    }
}
