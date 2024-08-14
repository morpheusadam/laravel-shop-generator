<?php

namespace Modules\Product\Entities\Concerns;

trait ModelMutators
{
    public function setVariantAttribute($variant) {
        $this->variant = $variant;
    }
}
