<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
            'uid' => $this->uid,
            'uids' => $this->uids,
            'name' => $this->name,
            'position' => $this->position,
            'media' => $this->files->map->only('id', 'path'),
            'manage_stock' => $this->manage_stock,
            'qty' => $this->qty,
            'in_stock' => $this->in_stock,
            'sku' => $this->sku,
            'price' => $this->price->amount(),
            'special_price_type' => $this->special_price_type,
            'special_price' => $this->special_price?->amount(),
            'is_active' => $this->is_active,
            'is_default' => $this->is_default,
        ];
    }
}
