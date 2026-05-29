<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['sku']) || empty($row['name']) || !isset($row['price']) || !isset($row['stock'])) {
            return null;
        }

        return Product::updateOrCreate(
            ['sku' => $row['sku']],
            [
                'name'        => $row['name'],
                'description' => $row['description'] ?? null,
                'price'       => (float) str_replace(',', '.', $row['price']),
                'stock'       => (int) $row['stock'],
                'image'       => $row['image'] ?? null,
                'category'    => $row['category'] ?? null,
            ]
        );
    }
}
