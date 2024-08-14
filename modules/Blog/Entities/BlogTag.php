<?php

namespace Modules\Blog\Entities;

use Modules\Support\Eloquent\Model;
use Modules\Blog\Admin\BlogTagTable;
use Modules\Meta\Eloquent\HasMetaData;
use Modules\Support\Eloquent\Sluggable;
use Modules\Support\Eloquent\Translatable;

class BlogTag extends Model
{
    use Translatable, Sluggable, HasMetaData;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * The attribute that will be slugged.
     *
     * @var string
     */
    protected $slugAttribute = 'name';


    public function table()
    {
        return new BlogTagTable($this->query());
    }


    public function tags()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_blog_tag');
    }


    public function blogPosts()
    {
        return $this->belongsToMany(BlogPost::class);
    }
}
