<?php

namespace Modules\Cart\Storages;

use Modules\Cart\Entities\Cart;
use Darryldecode\Cart\CartCollection;

class Database
{
    public function get($key)
    {
        if ($this->has($key)) {
            return new CartCollection(Cart::find($key)->data);
        } else {
            return [];
        }
    }


    public function put($key, $value)
    {
        if ($row = Cart::find($key)) {
            $row->data = $value;
            $row->save();
        } else {
            Cart::create([
                'id' => $key,
                'data' => $value,
            ]);
        }
    }


    private function has($key)
    {
        return Cart::find($key);
    }
}
