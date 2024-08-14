<?php

namespace Modules\Variation\Entities;

use Modules\Support\Eloquent\TranslationModel;

class VariationValueTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['label'];
}
