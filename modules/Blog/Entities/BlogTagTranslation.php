<?php

namespace Modules\Blog\Entities;

use Modules\Support\Eloquent\TranslationModel;

class BlogTagTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
