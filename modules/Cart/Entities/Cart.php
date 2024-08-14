<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'data',
    ];


    public function getDataAttribute($value)
    {
        return unserialize($value);
    }


    public function setDataAttribute($value)
    {
        $this->attributes['data'] = serialize($value);
    }
}
