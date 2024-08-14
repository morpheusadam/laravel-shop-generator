<?php

use Modules\Setting\Repositories\SettingRepository;

if (!function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed, we'll assume you want to set settings.
     *
     * @param string|array $key
     * @param mixed $default
     *
     * @return mixed|SettingRepository
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        if (is_array($key)) {
            return app('setting')->set($key);
        }

        try {
            return app('setting')->get($key, $default);
        } catch (PDOException) {
            return $default;
        }
    }
}
