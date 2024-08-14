<?php

namespace Modules\Variation\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uid' => $this->uid,
            'name' => $this->name,
            'type' => $this->type,
            'is_global' => $this->is_global,
            'values' => VariationValueResource::collection($this->values->sortBy('position')),
        ];
    }
}
