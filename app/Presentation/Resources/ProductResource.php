<?php

namespace App\Presentation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'sku' => $this->sku,
            'specifications' => $this->specifications,
            'is_active' => $this->is_active,
            'vendor' => new VendorResource($this->whenLoaded('vendor')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}