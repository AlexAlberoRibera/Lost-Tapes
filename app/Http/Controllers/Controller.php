<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Lost Tapes API',
    version: '1.0.0',
    description: 'API para la tienda de cine de culto Lost Tapes. Permite consultar el catálogo de películas, gestionar el catálogo (admin/vendedor) y autenticarse mediante Sanctum.'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'token'
)]
abstract class Controller
{
    //
}
