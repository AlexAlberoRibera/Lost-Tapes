<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Product',
    title: 'Product',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'sku', type: 'string', example: 'LT-0001'),
        new OA\Property(property: 'name', type: 'string', example: 'Blade Runner'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Película de culto de ciencia ficción.'),
        new OA\Property(property: 'category', type: 'string', example: 'Ciencia ficción'),
        new OA\Property(property: 'price', type: 'string', example: '19.99'),
        new OA\Property(property: 'stock', type: 'integer', example: 10),
        new OA\Property(property: 'image', type: 'string', nullable: true, example: 'blade-runner.jpg'),
    ]
)]
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
