<?php

namespace Modules\Variation\Entities;

use Illuminate\Support\Collection;
use Modules\Support\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Support\Eloquent\Translatable;
use Modules\Variation\Admin\VariationTable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variation extends Model
{
    use Translatable, SoftDeletes;

    /**
     * Available variation types.
     *
     * @var array
     */
    const TYPES = ['text', 'color', 'image'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations', 'values'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uid', 'type', 'is_global', 'position'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_global' => 'boolean',
        'deleted_at' => 'datetime'
    ];


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected array $translatedAttributes = ['name'];


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::saved(function ($variation) {
            if (request()->routeIs('admin.variations.*')) {
                $variation->saveValuesForGlobal();
            }

            if (request()->routeIs('admin.products.*')) {
                $variation->saveValuesForLocal();
            }
        });
    }


    /**
     * Save values for the variation.
     *
     * @param array $values
     *
     * @return void
     */
    public function saveValues(array $values = []): void
    {
        $ids = $this->getDeleteCandidates($values);

        if ($ids->isNotEmpty()) {
            $this->values()
                ->whereIn('id', $ids)
                ->delete();
        }

        $counter = 0;

        foreach (array_reset_index($values) as $attributes) {
            $attributes += ['position' => ++$counter];
            $attributes += ['value' => $attributes['color'] ?? ''];

            $this->values()->updateOrCreate(
                [
                    'id' => array_get($attributes, 'id'),
                ],
                $attributes,
            );
        }
    }


    /**
     * Get the values for the variation.
     *
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(VariationValue::class);
    }


    /**
     * Scope a query to only include global variations.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeGlobals(Builder $query): Builder
    {
        return $query->where('is_global', true);
    }


    /**
     * Get table data for the resource
     *
     * @return VariationTable
     */
    public function table(): VariationTable
    {
        return new VariationTable($this->newQuery()->globals());
    }


    protected function saveValuesForGlobal()
    {
        $this->saveValues(request('values', []));
    }


    protected function saveValuesForLocal()
    {
        $this->saveValues(
            request('variations.' . $this->uid . '.values', [])
        );
    }


    /**
     * @param $values
     *
     * @return Collection
     */
    private function getDeleteCandidates($values): Collection
    {
        return $this->values()
            ->pluck('id')
            ->diff(array_pluck($values, 'id'));
    }
}
