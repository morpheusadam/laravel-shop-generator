<?php

namespace Modules\Brand\Entities;

use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Carbon;
use Modules\Media\Entities\File;
use Illuminate\Http\JsonResponse;
use Modules\Brand\Admin\BrandTable;
use Modules\Support\Eloquent\Model;
use Modules\Media\Eloquent\HasMedia;
use Illuminate\Support\Facades\Cache;
use Modules\Product\Entities\Product;
use Modules\Meta\Eloquent\HasMetaData;
use Modules\Support\Eloquent\Sluggable;
use Spatie\Sitemap\Contracts\Sitemapable;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model implements Sitemapable
{
    use Translatable, Sluggable, HasMedia, HasMetaData;

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];
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
    protected $fillable = ['slug', 'is_active'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
    /**
     * The attribute that will be slugged.
     *
     * @var string
     */
    protected $slugAttribute = 'name';


    /**
     * Find a specific brand by the given slug.
     *
     * @param string $slug
     *
     * @return self
     */
    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->firstOrNew([]);
    }


    /**
     * Get brand list.
     *
     * @return Collection
     */
    public static function list()
    {
        return Cache::tags('brands')->rememberForever(md5('brands.list:' . locale()), function () {
            return self::all()->sortBy('name')->pluck('name', 'id');
        });
    }


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addActiveGlobalScope();
    }


    /**
     * Get public url for the brand.
     *
     * @return string
     */
    public function url()
    {
        return route('brands.products.index', $this->slug);
    }


    /**
     * Get the brand's logo.
     *
     * @return File
     */
    public function getLogoAttribute()
    {
        return $this->files->where('pivot.zone', 'logo')->first() ?: new File;
    }


    /**
     * Get the brand's banner.
     *
     * @return File
     */
    public function getBannerAttribute()
    {
        return $this->files->where('pivot.zone', 'banner')->first() ?: new File;
    }


    /**
     * Get related products.
     *
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    /**
     * Get table data for the resource
     *
     * @return JsonResponse
     */
    public function table()
    {
        return new BrandTable($this->newQuery()->withoutGlobalScope('active'));
    }


    public function toSitemapTag(): Url|string|array
    {
        return Url::create($this->url())
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1);
    }
}
