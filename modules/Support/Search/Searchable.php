<?php

namespace Modules\Support\Search;

use Laravel\Scout\Searchable as ScoutSearchable;

trait Searchable
{
    use ScoutSearchable {
        ScoutSearchable::search as scoutSearch;
    }

    /**
     * Perform a search against the model's indexed data.
     *
     * @param string $query
     * @param Closure $callback
     *
     * @return Builder
     */
    public function search($query, $callback = null): Builder
    {
        $scoutBuilder = $this->scoutSearch($query, $callback);

        return new Builder($this, $scoutBuilder);
    }
}
