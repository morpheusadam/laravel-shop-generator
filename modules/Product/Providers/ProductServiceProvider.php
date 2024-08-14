<?php

namespace Modules\Product\Providers;

use Modules\Product\RecentlyViewed;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Product\Http\ViewComposers\ProductEditPageComposer;
use Modules\Product\Http\ViewComposers\ProductCreatePageComposer;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('product::admin.products.create', ProductCreatePageComposer::class);
        View::composer('product::admin.products.edit', ProductEditPageComposer::class);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(RecentlyViewed::class, function ($app) {
            return new RecentlyViewed(
                $app['session'],
                $app['events'],
                'recently_viewed',
                session()->getId() . '_recently_viewed',
                config('fleetcart.modules.product.config.recently_viewed')
            );
        });

        $this->app->alias(RecentlyViewed::class, 'recently_viewed');
    }
}
