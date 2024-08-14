<?php

namespace Modules\Product\Entities\Concerns;

trait Predicates
{
    /**
     * Is this Product purchased by the current user?
     *
     * @return bool
     */
    public function purchasedByUser(): bool
    {
        //TODO: implement
        return true;
    }


    public function hasAnyVariation()
    {
        return $this->getAttribute('variations')->isNotEmpty();
    }


    public function hasAnyVariants(): bool
    {
        return $this->getAttribute('variants')->isNotEmpty();
    }


    public function hasAnyOption(): bool
    {
        return $this->getAttribute('options')->isNotEmpty();
    }


    public function hasAnyAttribute(): bool
    {
        return $this->getAttribute('attributes')->isNotEmpty();
    }
}
