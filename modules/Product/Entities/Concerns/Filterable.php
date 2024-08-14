<?php

namespace Modules\Product\Entities\Concerns;

trait Filterable
{
    public function filter($filter)
    {
        return $filter->apply($this);
    }
}
