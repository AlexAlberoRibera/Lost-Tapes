<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'sku'         => $this->sku,
            'name'        => $this->name,
            'description' => $this->description,
            'category'    => $this->category,
            'price'       => number_format($this->price, 2),
            'stock'       => $this->stock,
            'image'       => $this->image,
        ];
    }
}
