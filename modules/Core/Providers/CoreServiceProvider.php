<?php

namespace Modules\Core\Providers;

use Exception;
use Modules\Support\Locale;
use Modules\Setting\Entities\Setting;
use Illuminate\Support\ServiceProvider;
use FleetCart\Http\Middleware\LicenseChecker;
use Modules\Core\Http\Middleware\Authenticate;
use Modules\Core\Http\Middleware\Authorization;
use Modules\Core\Http\Middleware\GuestMiddleware;
use Modules\Core\Http\Middleware\AdminMiddleware;
use Modules\Setting\Repositories\SettingRepository;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Core module specific middleware.
     *
     * @var array
     */
    protected $middleware = [
        'auth' => Authenticate::class,
        'admin' => AdminMiddleware::class,
        'licensed' => LicenseChecker::class,
        'guest' => GuestMiddleware::class,
        'can' => Authorization::class,
        'localize' => LaravelLocalizationRoutes::class,
        'locale_session_redirect' => LocaleSessionRedirect::class,
        'localization_redirect' => LaravelLocalizationRedirectFilter::class,
    ];


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

        $this->setupSupportedLocales();
        $this->registerSetting();
        $this->setupAppLocale();
        $this->setupAppCacheDriver();
        $this->hideDefaultLocaleInURL();
        $this->setupAppTimezone();
        $this->setupMailConfig();
        $this->registerMiddleware();
        $this->registerInAdminPanelState();
        $this->blacklistAdminRoutesOnFrontend();
    }


    /**
     * Setup supported locales.
     *
     * @return void
     */
    private function setupSupportedLocales()
    {
        $supportedLocales = [];

        foreach ($this->getSupportedLocales() as $locale) {
            $supportedLocales[$locale]['name'] = Locale::name($locale);
        }

        $this->app['config']->set('laravellocalization.supportedLocales', $supportedLocales);
    }


    /**
     * Get supported locales from database.
     *
     * @return array
     */
    private function getSupportedLocales()
    {
        try {
            return Setting::get('supported_locales', [config('app.locale')]);
        } catch (Exception $e) {
            return [config('app.locale')];
        }
    }


    /**
     * Register setting binding.
     *
     * @return void
     */
    private function registerSetting()
    {
        $this->app->singleton('setting', function () {
            return new SettingRepository(Setting::allCached());
        });
    }


    /**
     * Setup application locale.
     *
     * @return string
     */
    private function setupAppLocale()
    {
        $this->app['config']->set('app.locale', $defaultLocale = Setting::get('default_locale'));
        $this->app['config']->set('app.fallback_locale', $defaultLocale);

        $locale = is_null(LaravelLocalization::setLocale()) ? $defaultLocale : null;

        LaravelLocalization::setLocale($locale);
    }


    /**
     * Setup application cache driver.
     *
     * @return void
     */
    private function setupAppCacheDriver()
    {
        $this->app['config']->set('cache.default', config('app.cache') ? 'file' : 'array');
    }


    /**
     * Hide default locale in url for non multi-locale mode.
     *
     * @return void
     */
    private function hideDefaultLocaleInURL()
    {
        if (!is_multilingual()) {
            $this->app['config']->set('laravellocalization.hideDefaultLocaleInURL', true);
        }
    }


    /**
     * Setup application timezone.
     *
     * @return void
     */
    private function setupAppTimezone()
    {
        $timezone = setting('default_timezone') ?? config('app.timezone');

        date_default_timezone_set($timezone);

        $this->app['config']->set('app.timezone', $timezone);
    }


    /**
     * Setup application mail config.
     *
     * @return void
     */
    private function setupMailConfig()
    {
        $this->app['config']->set('mail.default', 'smtp');
        $this->app['config']->set('mail.from.address', setting('mail_from_address'));
        $this->app['config']->set('mail.from.name', setting('mail_from_name'));
        $this->app['config']->set('mail.mailers.smtp.host', setting('mail_host'));
        $this->app['config']->set('mail.mailers.smtp.port', setting('mail_port'));
        $this->app['config']->set('mail.mailers.smtp.username', setting('mail_username'));
        $this->app['config']->set('mail.mailers.smtp.password', setting('mail_password'));
        $this->app['config']->set('mail.mailers.smtp.encryption', setting('mail_encryption'));
    }


    /**
     * Register the filters.
     *
     * @return void
     */
    private function registerMiddleware()
    {
        foreach ($this->middleware as $name => $middleware) {
            $this->app['router']->aliasMiddleware($name, $middleware);
        }
    }


    /**
     * Register inAdminPanel state to the IoC container.
     *
     * @return void
     */
    private function registerInAdminPanelState()
    {
        if ($this->app->runningInConsole()) {
            return $this->app['inAdminPanel'] = false;
        }

        $index = in_array($this->app['request']->segment(1), setting('supported_locales'))
            ? 2
            : 1;

        $this->app['inAdminPanel'] = $this->app['request']->segment($index) === 'admin';
    }


    /**
     * Blacklist admin routes on frontend for ziggy package.
     *
     * @return void
     */
    private function blacklistAdminRoutesOnFrontend()
    {
        if (!$this->app['inAdminPanel']) {
            $this->app['config']->set('ziggy.except',
                array_merge(
                    $this->app['config']->get('ziggy.except'),
                    [
                        'admin.*',
                    ]
                )
            );
        }
    }
}
