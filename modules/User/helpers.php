<?php

if (!function_exists('permission_value')) {
    /**
     * Get the integer representation value of the permission.
     *
     * @param array $permissions
     * @param string $permission
     *
     * @return int
     */
    function permission_value(array $permissions, $permission)
    {
        $value = array_get($permissions, $permission);

        if (is_null($value)) {
            return 0;
        } else if ($value) {
            return 1;
        } else if (!$value) {
            return -1;
        }
    }
}
