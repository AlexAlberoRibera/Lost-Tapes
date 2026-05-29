<?php

namespace App\Imports;
/*
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        // Validamos que existan los campos obligatorios
        if (!isset($row['sku'], $row['name'], $row['price'], $row['stock'])) {
            return null; // fila inválida, se ignora
        }

        // Insertar o actualizar producto
        return Product::updateOrCreate(
            ['sku' => $row['sku']],
            [
                'name' => $row['name'],
                'description' => $row['description'] ?? null,
                'price' => $row['price'],
                'stock' => $row['stock'],
                'image' => $row['image'] ?? null,
                'category' => $row['category'] ?? null,
            ]
        );
    }
}*/
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
{
    return Product::updateOrCreate(
        ['sku' => $row['sku']], // clave única
        [
            'name' => $row['name'],
            'description' => $row['description'] ?? null,
            'price' => (float) str_replace(',', '.', $row['price']),
            'stock' => (int) $row['stock'],
            'image' => $row['image'] ?? null,
            'category' => $row['category'] ?? null,
        ]
    );
}
}