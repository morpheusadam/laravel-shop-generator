<?php

namespace Modules\Shipping\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Modules\Shipping\ShippingMethodManager;

/**
 * @method static Collection available()
 * @method static Collection all()
 * @method static array names()
 * @method static object get(string $name)
 * @method static ShippingMethodManager register(string $name, callable|object $driver)
 * @method static int count()
 * @method static bool isEmpty()
 * @method static bool isNotEmpty()
 *
 * @see ShippingMethodManager
 */
class ShippingMethod extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ShippingMethodManager::class;
    }
}
