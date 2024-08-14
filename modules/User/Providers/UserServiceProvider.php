<?php

namespace Modules\User\Providers;

use Modules\User\Admin\RoleTabs;
use Modules\User\Admin\UserTabs;
use Modules\User\Guards\Sentinel;
use Modules\User\Admin\ProfileTabs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\User\Contracts\Authentication;
use Modules\User\Sentinel\SentinelAuthentication;
use Modules\User\Http\ViewComposers\AuthLayoutComposer;
use Modules\User\Http\ViewComposers\CurrentUserComposer;

class UserServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!config('app.installed')) {
            return;
        }

        TabManager::register('users', UserTabs::class);
        TabManager::register('roles', RoleTabs::class);
        TabManager::register('profile', ProfileTabs::class);

        View::composer('*', CurrentUserComposer::class);
        View::composer('user::admin.auth.*', AuthLayoutComposer::class);

        $this->registerSentinelGuard();
        $this->registerBladeDirectives();
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Authentication::class, SentinelAuthentication::class);
    }


    /**
     * Register sentinel guard.
     *
     * @return void
     */
    private function registerSentinelGuard()
    {
        Auth::extend('sentinel', function () {
            return new Sentinel;
        });
    }


    /**
     * Register blade directives.
     *
     * @return void
     */
    private function registerBladeDirectives()
    {
        Blade::directive('hasAccess', function ($permissions) {
            return "<?php if (\$currentUser->hasAccess($permissions)) : ?>";
        });

        Blade::directive('endHasAccess', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('hasAnyAccess', function ($permissions) {
            return "<?php if (\$currentUser->hasAnyAccess($permissions)) : ?>";
        });

        Blade::directive('endHasAnyAccess', function () {
            return '<?php endif; ?>';
        });
    }
}
