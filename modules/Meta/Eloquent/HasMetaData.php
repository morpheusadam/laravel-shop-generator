<?php

namespace Modules\Meta\Eloquent;

use Modules\Meta\Entities\MetaData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasMetaData
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootHasMetaData()
    {
        static::saved(function ($entity) {
            $entity->saveMetaData(request('meta', []));
        });
    }


    /**
     * Save metadata for the entity.
     *
     * @param array $data
     *
     * @return Model
     */
    public function saveMetaData($data = [])
    {
        $this->meta->fill([locale() => $data])->save();
    }


    /**
     * Get the meta for the entity.
     *
     * @return MorphToMany
     */
    public function meta()
    {
        return $this->morphOne(MetaData::class, 'entity')->withDefault();
    }
}
