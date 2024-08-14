<?php

namespace Modules\Variation\Entities;

use Modules\Support\Eloquent\TranslationModel;

class VariationTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
