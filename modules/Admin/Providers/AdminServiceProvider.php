<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\View;
use Modules\Admin\Ui\Facades\Form;
use Illuminate\Pagination\Paginator;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Http\ViewComposers\LayoutComposer;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultSimpleView('admin::pagination.simple');

        View::composer('admin::layout', LayoutComposer::class);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        AliasLoader::getInstance()->alias('Form', Form::class);
    }
}
