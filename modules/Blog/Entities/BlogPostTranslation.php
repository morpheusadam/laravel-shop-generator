<?php

namespace Modules\Blog\Entities;

use Modules\Support\Eloquent\TranslationModel;

class BlogPostTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];
}
