<?php

namespace Modules\Support\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PWAServiceProvider extends ServiceProvider
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

        config([
            'pwa.manifest.name' => setting('store_name'),
            'pwa.manifest.description' => setting('store_tagline', ''),
            'pwa.manifest.short_name' => setting('store_name'),
            'pwa.manifest.theme_color' => setting('pwa_theme_color'),
            'pwa.manifest.background_color' => setting('pwa_background_color'),
            'pwa.manifest.status_bar' => setting('pwa_theme_color'),
            'pwa.manifest.display' => setting('pwa_display'),
            'pwa.manifest.orientation' => setting('pwa_orientation'),
            'pwa.manifest.direction' => setting('pwa_direction'),
            'pwa.manifest.lang' => setting('default_locale'),
        ]);

        $this->registerDirective();
    }


    /**
     * Register directive.
     *
     * @return void
     */
    public function registerDirective(): void
    {
        Blade::directive('PWA', function () {
            return "<?php \$config = (new \Modules\Support\Services\ManifestService())->generate(); echo \$__env->make( 'support::pwa.meta' , ['config' => \$config])->render(); ?>";
        });
    }
}
