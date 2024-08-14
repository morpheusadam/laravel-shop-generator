<?php

namespace Modules\Cart\Storages;

use Darryldecode\Cart\CartCollection;
use Illuminate\Support\Facades\Cookie;

class Cache
{
    private $data = [];
    private $cart_id;


    public function __construct()
    {
        $this->cart_id = Cookie::get('cart');

        if ($this->cart_id) {
            $this->data = Cache::get('cart_' . $this->cart_id);
        } else {
            $this->cart_id = uniqid();
        }
    }


    public function get($key)
    {
        return new CartCollection($this->data[$key] ?? []);
    }


    public function put($key, $value)
    {
        $this->data[$key] = $value;
        Cache::put('cart_' . $this->cart_id, $this->data);

        if (!Cookie::hasQueued('cart')) {
            Cookie::queue(
                Cookie::make('cart', $this->cart_id, 60 * 24 * 30)
            );
        }
    }


    public function has($key)
    {
        return isset($this->data[$key]);
    }
}
