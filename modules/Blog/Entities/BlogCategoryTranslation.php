<?php

namespace Modules\Blog\Entities;

use Modules\Support\Eloquent\TranslationModel;

class BlogCategoryTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
