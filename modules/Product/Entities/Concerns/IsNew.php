<?php

namespace Modules\Product\Entities\Concerns;

trait IsNew
{
    public function isNew(): bool
    {
        if ($this->hasNewFromDate() && $this->hasNewToDate()) {
            return $this->newFromDateIsValid() && $this->newToDateIsValid();
        }

        if ($this->hasNewFromDate()) {
            return $this->newFromDateIsValid();
        }

        if ($this->hasNewToDate()) {
            return $this->newToDateIsValid();
        }

        return false;
    }


    private function hasNewFromDate(): bool
    {
        return !is_null($this->new_from);
    }


    private function hasNewToDate(): bool
    {
        return !is_null($this->new_to);
    }


    private function newFromDateIsValid(): bool
    {
        return today() >= $this->new_from;
    }


    private function newToDateIsValid(): bool
    {
        return today() <= $this->new_to;
    }
}
