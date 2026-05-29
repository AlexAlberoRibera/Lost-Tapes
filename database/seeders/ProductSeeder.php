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
            'description' => 'Obra maestra de Tarkovsky. Incluye comentario del director y libreto de 40 páginas sobre la iconografía medieval.',
            'price' => 19.99,
            'stock' => 50,
            'image' => 'andreiRublev.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU002',
            'name' => 'Marcado para matar',
            'description' => 'Yakuza surrealista de Seijun Suzuki. Con entrevista exclusiva al director sobre su despido de Nikkatsu.',
            'price' => 9.90,
            'stock' => 20,
            'image' => 'brandedToKill.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU003',
            'name' => 'Harakiri',
            'description' => 'Obra cumbre de Kobayashi. Incluye documental sobre el cine samurái y entrevista con Tatsuya Nakadai.',
            'price' => 21.99,
            'stock' => 15,
            'image' => 'harakiri.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU004',
            'name' => 'Cuentos de la luna pálida',
            'description' => 'Fantasía de Kenji Mizoguchi. Con análisis de la fotografía de Kazuo Miyagawa y ensayo sobre el cine de fantasmas japonés.',
            'price' => 18.99,
            'stock' => 25,
            'image' => 'ugetsu.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU005',
            'name' => 'El intendente Sansho',
            'description' => 'Drama de Mizoguchi. Incluye comentario del crítico Tony Rayns y libreto sobre el humanismo en el cine japonés.',
            'price' => 22.50,
            'stock' => 18,
            'image' => 'sansho.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU006',
            'name' => 'El carterista',
            'description' => 'Obra maestra de Robert Bresson. Con entrevista al director sobre su teoría del cinematógrafo y modelos no-actores.',
            'price' => 17.99,
            'stock' => 30,
            'image' => 'pickpocket.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU007',
            'name' => 'Al azar de Baltasar',
            'description' => 'Bresson en estado puro. Incluye documental sobre la filmografía del director y ensayo de Paul Schrader.',
            'price' => 19.99,
            'stock' => 22,
            'image' => 'balthazar.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU008',
            'name' => 'Un condenado a muerte se ha escapado',
            'description' => 'Suspense minimalista de Bresson. Con comentario de audio del estudioso de cine James Quandt.',
            'price' => 16.99,
            'stock' => 28,
            'image' => 'manEscaped.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU009',
            'name' => 'Stalker',
            'description' => 'Ciencia ficción metafísica de Tarkovsky. Con making-of sobre las difíciles condiciones de rodaje y entrevista a Alexander Kaidanovsky.',
            'price' => 24.99,
            'stock' => 35,
            'image' => 'stalker.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU010',
            'name' => 'El espejo',
            'description' => 'Poema cinematográfico de Tarkovsky. Incluye análisis de la estructura no-lineal y entrevista al cinematógrafo Georgy Rerberg.',
            'price' => 23.50,
            'stock' => 40,
            'image' => 'mirror.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU011',
            'name' => 'Solaris',
            'description' => 'Respuesta de Tarkovsky a 2001. Con documental sobre la adaptación de Stanisław Lem y efectos especiales de la época soviética.',
            'price' => 21.99,
            'stock' => 45,
            'image' => 'solaris.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU012',
            'name' => 'Persona',
            'description' => 'Obra maestra psicológica de Bergman. Con entrevista a Liv Ullmann y Bibi Andersson sobre la intensidad del rodaje.',
            'price' => 20.99,
            'stock' => 38,
            'image' => 'persona.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU013',
            'name' => 'El séptimo sello',
            'description' => 'Alegoría medieval de Bergman. Incluye comentario del director y documental sobre el simbolismo de la muerte.',
            'price' => 18.99,
            'stock' => 50,
            'image' => 'seventhSeal.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU014',
            'name' => 'Fresas salvajes',
            'description' => 'Drama existencial de Bergman. Con entrevista a Max von Sydow y ensayo sobre el viaje como metáfora.',
            'price' => 17.50,
            'stock' => 32,
            'image' => 'wildStrawberries.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU015',
            'name' => 'Gritos y susurros',
            'description' => 'Intimismo de Bergman. Incluye análisis del uso del color rojo y entrevista al cinematógrafo Sven Nykvist.',
            'price' => 22.99,
            'stock' => 24,
            'image' => 'criesWhispers.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU016',
            'name' => 'Dios y el diablo en la tierra del sol',
            'description' => 'Manifiesto del Cinema Novo de Glauber Rocha. Con entrevista al director sobre el tercer cine y la estética del hambre.',
            'price' => 19.99,
            'stock' => 15,
            'image' => 'blackGodWhiteDevil.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU017',
            'name' => 'Antonio das Mortes',
            'description' => 'Western místico de Glauber Rocha. Incluye documental sobre el movimiento Cinema Novo brasileño.',
            'price' => 18.50,
            'stock' => 12,
            'image' => 'antonioDasMortes.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU018',
            'name' => 'Tierra en trance',
            'description' => 'Alegoría política de Glauber Rocha. Con análisis del contexto de la dictadura brasileña y soundtrack completo.',
            'price' => 20.50,
            'stock' => 10,
            'image' => 'entrancedEarth.jpg',
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU019',
            'name' => 'La aventura',
            'description' => 'Antonioni redefine el tiempo cinematográfico. Con comentario de críticos y entrevista a Monica Vitti sobre el silencio en pantalla.',
            'price' => 21.99,
            'stock' => 27,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU020',
            'name' => 'La noche',
            'description' => 'Trilogía de la incomunicación de Antonioni. Incluye galería fotográfica de Gianni Di Venanzo y ensayo sobre el vacío existencial.',
            'price' => 20.99,
            'stock' => 23,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU021',
            'name' => 'Ocho y medio',
            'description' => 'Autorretrato de Fellini. Con making-of narrado por Marcello Mastroianni y análisis de los sueños cinematográficos.',
            'price' => 23.99,
            'stock' => 42,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU022',
            'name' => 'Cuentos de Tokio',
            'description' => 'Obra maestra de Ozu. Incluye documental sobre los pillow shots y entrevista al actor Chishū Ryū sobre trabajar con Ozu.',
            'price' => 19.99,
            'stock' => 35,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU023',
            'name' => 'Primavera tardía',
            'description' => 'Melancolía de Ozu. Con comentario del especialista David Bordwell y análisis de la composición tatami-shot.',
            'price' => 18.50,
            'stock' => 29,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU024',
            'name' => 'La condición humana',
            'description' => 'Épica humanista de Kobayashi (trilogía completa). Con entrevista a Tatsuya Nakadai y libreto de 60 páginas sobre el pacifismo japonés.',
            'price' => 39.99,
            'stock' => 8,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU025',
            'name' => 'Kwaidan',
            'description' => 'Antología de fantasmas de Kobayashi. Incluye documental sobre los sets pintados a mano y entrevista al compositor Tōru Takemitsu.',
            'price' => 24.99,
            'stock' => 16,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU026',
            'name' => 'Mouchette',
            'description' => 'Drama brutal de Bresson. Con análisis de la interpretación no-profesional y ensayo sobre la crueldad humana.',
            'price' => 17.99,
            'stock' => 21,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU027',
            'name' => 'El acorazado Potemkin',
            'description' => 'Revolución del montaje de Eisenstein. Con comentario sobre la escalera de Odessa y restauración digital del tintado original.',
            'price' => 16.99,
            'stock' => 33,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU028',
            'name' => 'Iván el Terrible',
            'description' => 'Opera visual de Eisenstein (Parte I y II). Incluye análisis del uso del color en Parte II y score completo de Prokofiev.',
            'price' => 28.99,
            'stock' => 14,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU029',
            'name' => 'Aguirre, la cólera de Dios',
            'description' => 'Locura en el Amazonas de Herzog. Con diario de rodaje del director y entrevista a Klaus Kinski sobre su relación tóxica en el set.',
            'price' => 20.99,
            'stock' => 31,
            'image' => null,
            'category' => 'pelicula',
        ]);

        Product::create([
            'sku' => 'SKU030',
            'name' => 'La pasión de Juana de Arco',
            'description' => 'Obra maestra silente de Dreyer. Restauración completa con partitura de Richard Einhorn y ensayo sobre los close-ups de Falconetti.',
            'price' => 22.99,
            'stock' => 26,
            'image' => null,
            'category' => 'pelicula',
        ]);
    }
}