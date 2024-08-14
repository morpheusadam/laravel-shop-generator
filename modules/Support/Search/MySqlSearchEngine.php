<?php

namespace Modules\Support\Search;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Illuminate\Database\Eloquent\Model;

class MySqlSearchEngine extends Engine
{
    public function update($models)
    {
        //
    }


    public function delete($models)
    {
        //
    }


    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param mixed $results
     *
     * @return Collection
     */
    public function mapIds($results)
    {
        return $results['results'];
    }


    /**
     * Perform the given search on the engine.
     *
     * @param \Modules\Support\Search\Builder $builder
     * @param int $perPage
     * @param int $page
     *
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        $builder->limit = $perPage;
        $builder->offset = ($perPage * $page) - $perPage;

        return $this->search($builder);
    }


    /**
     * Perform the given search on the engine.
     *
     * @param Builder $builder
     *
     * @return mixed
     */
    public function search(Builder $builder)
    {
        $result = [];

        $query = DB::table($builder->model->searchTable());

        $columns = implode(',', $builder->model->searchColumns());

        $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $this->getSearchKeyword($builder));

        if ($builder->callback) {
            $query = call_user_func($builder->callback, $query, $this);
        }

        $result['count'] = $query->count();

        if (property_exists($builder, 'orders') && !empty($builder->orders)) {
            foreach ($builder->orders as $order) {
                $query->orderBy($order['column'], $order['direction']);
            }
        }

        if ($builder->limit) {
            $query = $query->take($builder->limit);
        }

        if (property_exists($builder, 'offset') && $builder->offset) {
            $query = $query->skip($builder->offset);
        }

        $result['results'] = $query->pluck($builder->model->searchKey());

        return $result;
    }


    /**
     * Map the given results to instances of the given model.
     *
     * @param Laravel\Scout\Builder $builder
     * @param Model $model
     *
     * @return Collection
     */
    public function map(Builder $builder, $results, $model)
    {
        return $results['results'];
    }


    /**
     * Map the given results to instances of the given model via a lazy collection.
     *
     * @param Builder $builder
     * @param mixed $results
     * @param Model $model
     *
     * @return LazyCollection
     */
    public function lazyMap(Builder $builder, $results, $model)
    {
        //
    }


    /**
     * Get the totalPrice count from a raw result returned by the engine.
     *
     * @param mixed $results
     *
     * @return int
     */
    public function getTotalCount($results)
    {
        return $results['count'];
    }


    /**
     * Flush all the model's records from the engine.
     *
     * @param Model $model
     *
     * @return void
     */
    public function flush($model)
    {
        //
    }


    /**
     * Create a search index.
     *
     * @param string $name
     * @param array $options
     *
     * @return mixed
     */
    public function createIndex($name, array $options = [])
    {
        //
    }


    /**
     * Delete a search index.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function deleteIndex($name)
    {
        //
    }


    /**
     * Get the search query.
     *
     * @param Builder $builder
     *
     * @return string
     */
    private function getSearchKeyword($builder)
    {
        if (is_null($builder->query)) {
            return '';
        }

        return '+' . preg_replace('/[-+~*()><@"]/', ' ', $builder->query) . '*';
    }
}
