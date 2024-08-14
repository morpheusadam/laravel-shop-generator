<?php

namespace Modules\Option\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'is_global' => $this->is_global,
            'is_required' => $this->is_required,
            'values' => OptionValueResource::collection($this->values),
        ];
    }
}
