<?php

namespace Modules\Blog\Entities;

use Carbon\Carbon;
use Spatie\Sitemap\Tags\Url;
use Modules\User\Entities\User;
use Modules\Media\Entities\File;
use Modules\Support\Eloquent\Model;
use Modules\Media\Eloquent\HasMedia;
use Modules\Blog\Admin\BlogPostTable;
use Modules\Meta\Eloquent\HasMetaData;
use Modules\Support\Search\Searchable;
use Modules\Support\Eloquent\Sluggable;
use Spatie\Sitemap\Contracts\Sitemapable;
use Modules\Support\Eloquent\Translatable;

class BlogPost extends Model implements Sitemapable
{
    use Translatable, Sluggable, HasMedia, Searchable, HasMetaData;

    const PUBLISHED = 'published';
    const UNPUBLISHED = 'unpublished';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'user_id', 'blog_category_id', 'publish_status'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'description'];

    /**
     * The attribute that will be slugged.
     *
     * @var string
     */
    protected $slugAttribute = 'title';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['featured_image'];


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::saved(function ($blogPost) {
            $attributes = request()->all();

            if (!empty($attributes)) {
                $blogPost->tags()->sync(array_get($attributes, 'tags', []));
            }
        });
    }


    public function table()
    {
        return new BlogPostTable($this->query());
    }


    /**
     * Find a specific blog by the given slug.
     *
     * @param string $slug
     *
     * @return self
     */
    public static function findBySlug($slug)
    {
        return self::where('slug', $slug);
    }


    /**
     * Get related user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Get related category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }


    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_blog_tag');
    }


    /**
     * Get the indexable data array for the product.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        # MySQL Full-Text search handles indexing automatically.
        if (config('scout.driver') === 'mysql') {
            return [];
        }

        $translations = $this->translations()
            ->withoutGlobalScope('locale')
            ->get(['title', 'description']);

        return [
            'id' => $this->id,
            'translations' => $translations,
        ];
    }


    public function searchTable(): string
    {
        return 'blog_post_translations';
    }


    public function searchKey(): string
    {
        return 'blog_post_id';
    }


    public function searchColumns(): array
    {
        return ['title'];
    }


    public function getFeaturedImageAttribute()
    {
        return $this->files->where('pivot.zone', 'featured_image')->first() ?: new File;
    }


    public function getUserNameAttribute()
    {
        return $this->user->full_name;
    }


    public function scopePublished($query)
    {
        return $query->where('publish_status', 'published');
    }


    public function url(): string
    {
        return route('blog_posts.show', ['slug' => $this->slug]);
    }


    public function toSitemapTag(): Url|string|array
    {
        return Url::create($this->url())
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1);
    }
}
