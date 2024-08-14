<?php

namespace Modules\Option\Transformers;

use Modules\Support\Money;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price instanceof Money ? $this->price->amount() : $this->price,
            'price_type' => $this->price_type,
            'label' => $this->label,
        ];
    }
}
