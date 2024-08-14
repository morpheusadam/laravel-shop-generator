<?php

namespace Modules\Payment\Facades;

use Illuminate\Support\Collection;
use Modules\Payment\GatewayManager;
use Modules\Payment\GatewayInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection all()
 * @method static array names()
 * @method static GatewayInterface get(string $name)
 * @method static GatewayManager register(string $name, callable|object $driver)
 * @method static int count()
 * @method static bool isEmpty()
 * @method static bool isNotEmpty()
 *
 * @see GatewayManager
 */
class Gateway extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return GatewayManager::class;
    }
}
