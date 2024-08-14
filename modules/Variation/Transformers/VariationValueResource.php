<?php

namespace Modules\Variation\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationValueResource extends JsonResource
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
            'label' => $this->label,
            'image' => $this->when(
                condition: $this->variation->type === 'image',
                value: fn () => [
                    'id' => $this->image?->id,
                    'path' => $this->image?->path,
                ]
            ),
            'color' => $this->when(
                condition: $this->variation->type === 'color',
                value: $this->color
            ),
        ];
    }
}
