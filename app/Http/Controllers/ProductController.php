<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    #[OA\Get(
        path: '/api/products',
        summary: 'Listar películas',
        description: 'Devuelve el catálogo de películas paginado (10 por página). Permite filtrar por categoría y buscar por nombre.',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(
                name: 'category',
                in: 'query',
                required: false,
                description: 'Filtra por categoría exacta',
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'q',
                in: 'query',
                required: false,
                description: 'Busca por nombre (coincidencia parcial)',
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                description: 'Número de página',
                schema: new OA\Schema(type: 'integer', default: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Listado paginado de películas',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Product')
                        ),
                        new OA\Property(property: 'current_page', type: 'integer', example: 1),
                        new OA\Property(property: 'last_page', type: 'integer', example: 3),
                        new OA\Property(property: 'per_page', type: 'integer', example: 10),
                        new OA\Property(property: 'total', type: 'integer', example: 25),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request)
    {
        $query = Product::withCount('likes');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        return response()->json($query->paginate(10));
    }

    #[OA\Post(
        path: '/api/products',
        summary: 'Crear una película',
        description: 'Crea una nueva película en el catálogo. Requiere autenticación.',
        tags: ['Products'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['sku', 'name', 'price', 'stock', 'category'],
                properties: [
                    new OA\Property(property: 'sku', type: 'string', example: 'LT-0001'),
                    new OA\Property(property: 'name', type: 'string', example: 'Blade Runner'),
                    new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Película de culto de ciencia ficción.'),
                    new OA\Property(property: 'price', type: 'number', format: 'float', example: 19.99),
                    new OA\Property(property: 'stock', type: 'integer', example: 10),
                    new OA\Property(property: 'image', type: 'string', nullable: true, example: 'blade-runner.jpg'),
                    new OA\Property(property: 'category', type: 'string', example: 'Ciencia ficción'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Película creada',
                content: new OA\JsonContent(ref: '#/components/schemas/Product')
            ),
            new OA\Response(response: 401, description: 'No autenticado'),
            new OA\Response(response: 422, description: 'Error de validación'),
        ]
    )]
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }

    #[OA\Get(
        path: '/api/products/{product}',
        summary: 'Ver el detalle de una película',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(
                name: 'product',
                in: 'path',
                required: true,
                description: 'ID de la película',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Datos de la película',
                content: new OA\JsonContent(ref: '#/components/schemas/Product')
            ),
            new OA\Response(response: 404, description: 'Película no encontrada'),
        ]
    )]
    public function show(Product $product)
    {
        $product->loadCount('likes')->load(['comments.user']);
        $userLiked = auth('sanctum')->check()
            ? $product->likes()->where('user_id', auth('sanctum')->id())->exists()
            : false;

        $resource = (new ProductResource($product))->toArray(request());
        $resource['user_liked'] = $userLiked;

        return response()->json(['data' => $resource]);
    }

    #[OA\Post(
        path: '/api/products/{product}/like',
        summary: 'Toggle like en una película',
        description: 'Da o quita like a una película. Un usuario no puede dar dos likes al mismo producto — actúa como toggle. Requiere autenticación.',
        tags: ['Products'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'product',
                in: 'path',
                required: true,
                description: 'ID de la película',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Estado del like actualizado',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'liked', type: 'boolean', example: true),
                        new OA\Property(property: 'likes_count', type: 'integer', example: 4),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'No autenticado'),
            new OA\Response(response: 404, description: 'Película no encontrada'),
        ]
    )]
    public function like(Product $product)
    {
        $user = auth('sanctum')->user();
        if ($product->likes()->where('user_id', $user->id)->exists()) {
            $product->likes()->detach($user->id);
            $liked = false;
        } else {
            $product->likes()->attach($user->id);
            $liked = true;
        }
        return response()->json(['liked' => $liked, 'likes_count' => $product->likes()->count()]);
    }

    #[OA\Post(
        path: '/api/products/{product}/comments',
        summary: 'Añadir un comentario a una película',
        description: 'Crea un comentario asociado a la película. Requiere autenticación.',
        tags: ['Products'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'product',
                in: 'path',
                required: true,
                description: 'ID de la película',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['body'],
                properties: [
                    new OA\Property(property: 'body', type: 'string', example: 'Una obra maestra del cine de culto.'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Comentario creado',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'body', type: 'string', example: 'Una obra maestra del cine de culto.'),
                        new OA\Property(property: 'user', type: 'object',
                            properties: [new OA\Property(property: 'name', type: 'string', example: 'Maxi')]
                        ),
                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'No autenticado'),
            new OA\Response(response: 422, description: 'El campo body es obligatorio'),
        ]
    )]
    public function storeComment(Request $request, Product $product)
    {
        $request->validate(['body' => 'required|string|max:1000']);
        $comment = $product->comments()->create([
            'user_id' => auth('sanctum')->id(),
            'body'    => $request->body,
        ]);
        $comment->load('user');
        return response()->json($comment, 201);
    }

    #[OA\Put(
        path: '/api/products/{product}',
        summary: 'Actualizar una película',
        description: 'Actualiza una película existente. Requiere autenticación. Todos los campos son opcionales (solo se actualizan los enviados).',
        tags: ['Products'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'product',
                in: 'path',
                required: true,
                description: 'ID de la película',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'sku', type: 'string', example: 'LT-0001'),
                    new OA\Property(property: 'name', type: 'string', example: 'Blade Runner'),
                    new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Película de culto de ciencia ficción.'),
                    new OA\Property(property: 'price', type: 'number', format: 'float', example: 24.99),
                    new OA\Property(property: 'stock', type: 'integer', example: 5),
                    new OA\Property(property: 'image', type: 'string', nullable: true, example: 'blade-runner.jpg'),
                    new OA\Property(property: 'category', type: 'string', example: 'Ciencia ficción'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Película actualizada',
                content: new OA\JsonContent(ref: '#/components/schemas/Product')
            ),
            new OA\Response(response: 401, description: 'No autenticado'),
            new OA\Response(response: 404, description: 'Película no encontrada'),
            new OA\Response(response: 422, description: 'Error de validación'),
        ]
    )]
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json($product, 200);
    }

    #[OA\Delete(
        path: '/api/products/{product}',
        summary: 'Eliminar una película',
        description: 'Elimina una película del catálogo. Requiere autenticación.',
        tags: ['Products'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'product',
                in: 'path',
                required: true,
                description: 'ID de la película',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Película eliminada'),
            new OA\Response(response: 401, description: 'No autenticado'),
            new OA\Response(response: 404, description: 'Película no encontrada'),
        ]
    )]
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
