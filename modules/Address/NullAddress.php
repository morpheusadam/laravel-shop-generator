<?php

namespace Modules\Address;

use Illuminate\Contracts\Support\Arrayable;

class NullAddress implements Arrayable
{
    private $null;


    public function __construct($null = null)
    {
        $this->null = $null;
    }


    public function getFirstName()
    {
        return $this->null;
    }


    public function getLastName()
    {
        return $this->null;
    }


    public function getAddress1()
    {
        return $this->null;
    }


    public function getAddress2()
    {
        return $this->null;
    }


    public function getCity()
    {
        return $this->null;
    }


    public function getState()
    {
        return $this->null;
    }


    public function getZip()
    {
        return $this->null;
    }


    public function getCountry()
    {
        return $this->null;
    }


    public function toArray()
    {
        return [
            'first_name' => $this->null,
            'last_name' => $this->null,
            'address_1' => $this->null,
            'address_2' => $this->null,
            'country' => $this->null,
            'state' => $this->null,
            'city' => $this->null,
            'zip' => $this->null,
        ];
    }
}
