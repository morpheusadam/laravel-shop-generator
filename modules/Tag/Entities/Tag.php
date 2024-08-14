<?php

namespace Modules\Tag\Entities;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;
use Modules\Support\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Product\Entities\Product;
use Modules\Support\Eloquent\Sluggable;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use Translatable, Sluggable;

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
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attribute that will be slugged.
     *
     * @var string
     */
    protected $slugAttribute = 'name';


    /**
     * Get tag list.
     *
     * @return Collection
     */
    public static function list()
    {
        return Cache::tags('tags')->rememberForever(md5('tags.list:' . locale()), function () {
            return self::all()->sortBy('name')->pluck('name', 'id');
        });
    }


    /**
     * Find a tag by the given slug.
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
     * Get public url for tag products.
     *
     * @return string
     */
    public function url()
    {
        return route('tags.products.index', ['tag' => $this->slug]);
    }


    /**
     * Get related products.
     *
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags');
    }


    /**
     * Get table data for the resource
     *
     * @return JsonResponse
     */
    public function table()
    {
        return new AdminTable($this->query());
    }
}
