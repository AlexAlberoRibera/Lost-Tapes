<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'sku' => 'SKU001',
            'name' => 'Andrei Rublev',
            'description' => 'pelicula de tarkovsky',
            'price' => 19.99,
            'stock' => 50,
            'image' => 'andreiRublev.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU002',
            'name' => 'Branded To Kill',
            'description' => 'pelicula de seijun suzuki',
            'price' => 9.90,
            'stock' => 20,
            'image' => 'brandedToKill.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU003',
            'name' => 'Harakiri',
            'description' => 'pelicula de kobayashi',
            'price' => 21.99,
            'stock' => 15,
            'image' => 'harakiri.jpg',
            'category' => 'pelicula',
        ]);
    }
}