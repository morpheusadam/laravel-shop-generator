<?php

namespace Modules\Media\Eloquent;

use Modules\Media\Entities\File;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasMedia
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootHasMedia(): void
    {
        static::saved(function ($entity) {
            if (method_exists($entity, 'extractMediaFromRequest')) {
                $entity->syncFiles($entity->extractMediaFromRequest() ?? []);
            } else {
                $entity->syncFiles(request('files', []));
            }
        });
    }


    /**
     * Sync files for the entity.
     *
     * @param array $files
     */
    public function syncFiles(array $files = []): void
    {
        $entityType = get_class($this);

        foreach ($files as $zone => $fileIds) {
            $syncList = [];

            foreach (array_wrap($fileIds) as $fileId) {
                if (!empty($fileId)) {
                    $syncList[$fileId]['zone'] = $zone;
                    $syncList[$fileId]['entity_type'] = $entityType;
                }
            }

            $this->filterFiles($zone)->detach();
            $this->filterFiles($zone)->attach($syncList);
        }
    }


    /**
     * Filter files by zone.
     *
     * @param string $zone
     *
     * @return MorphToMany
     */
    public function filterFiles(string|array $zones): MorphToMany
    {
        return $this->files()->wherePivotIn('zone', array_wrap($zones));
    }


    /**
     * Get all the files for the entity.
     *
     * @return MorphToMany
     */
    public function files(): MorphToMany
    {
        return $this->morphToMany(File::class, 'entity', 'entity_files')
            ->withPivot(['id', 'zone'])
            ->withTimestamps();
    }
}
