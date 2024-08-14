<?php

namespace Modules\Address;


use Illuminate\Contracts\Support\Arrayable;

class StoreAddress implements Arrayable
{
    public function getAddress1()
    {
        return setting('store_address_1');
    }


    public function getAddress2()
    {
        return setting('store_address_1');
    }


    public function getCity()
    {
        return setting('store_address_1');
    }


    public function getState()
    {
        return setting('store_state');
    }


    public function getZip()
    {
        return setting('store_zip');
    }


    public function getCountry()
    {
        return setting('store_country');
    }


    public function toArray()
    {
        return [
            'address_1' => setting('store_address_1'),
            'address_2' => setting('store_address_2'),
            'city' => setting('store_city'),
            'state' => setting('store_state'),
            'zip' => setting('store_zip'),
            'country' => setting('store_country'),
        ];
    }
}
