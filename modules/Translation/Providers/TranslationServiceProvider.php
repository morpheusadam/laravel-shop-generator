<?php

namespace Modules\Translation\Providers;

use Illuminate\Support\Carbon;
use Astrotomic\Translatable\Locales;
use Illuminate\Translation\Translator;
use Illuminate\Support\ServiceProvider;
use Modules\Translation\TranslationLoader;

class TranslationServiceProvider extends ServiceProvider
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

        Carbon::setLocale(locale());

        $this->setupTranslatable();
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // The translation loader must be registered first.
        $this->registerLoader();
        $this->registerTranslator();
    }


    private function setupTranslatable()
    {
        $this->app['config']->set('translatable.use_fallback', true);
        $this->app['config']->set('translatable.fallback_locale', setting('default_locale'));
        $this->app['config']->set('translatable.locales', supported_locale_keys());

        // Re-register translatable locales helper after overriding config.
        $this->app->singleton('translatable.locales', Locales::class);
        $this->app->singleton(Locales::class);
    }


    private function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new TranslationLoader($app['files'], $app['path.lang']);
        });
    }


    private function registerTranslator()
    {
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $locale = $app['config']['app.locale'];

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });
    }
}
