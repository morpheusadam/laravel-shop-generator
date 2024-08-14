<?php

namespace FleetCart;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class Updater
{
    public static function run(): void
    {
        @set_time_limit(0);

        self::migrate();
        self::clearViewCache();
        self::clearConfigCache();
        self::clearRouteCache();
        self::clearAppCache();
        self::runScripts();

        File::delete(storage_path('app/update'));
    }


    private static function migrate(): void
    {
        if (config('app.installed')) {
            Artisan::call('migrate', ['--force' => true]);
        }
    }


    private static function clearViewCache(): void
    {
        Artisan::call('view:clear');
    }


    private static function clearConfigCache(): void
    {
        Artisan::call('config:clear');
    }


    private static function clearRouteCache(): void
    {
        Artisan::call('route:trans:clear');
    }


    private static function clearAppCache(): void
    {
        Artisan::call('cache:clear');
    }


    private static function runScripts(): void
    {
        $previouslyRan = DB::table('updater_scripts')->get();

        $ran = [];

        foreach (File::files(app_path('Scripts')) as $file) {
            require $file->getRealPath();

            $script = $file->getBasename('.php');

            if (!$previouslyRan->contains($script)) {
                resolve("FleetCart\\Scripts\\{$script}")->run();

                $ran[] = ['script' => $script];
            }
        }

        DB::table('updater_scripts')->insert($ran);
    }
}
