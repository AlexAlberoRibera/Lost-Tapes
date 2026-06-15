<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/api/login',
        summary: 'Iniciar sesión',
        description: 'Valida las credenciales y devuelve un token Sanctum para usarlo como Bearer token en el resto de peticiones.',
        tags: ['Auth'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: '1234'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login correcto',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', type: 'string', example: '1|abcdef123456789'),
                        new OA\Property(property: 'user', ref: '#/components/schemas/User'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Credenciales incorrectas'),
            new OA\Response(response: 422, description: 'Error de validación'),
        ]
    )]
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales incorrectas.'], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    #[OA\Post(
        path: '/api/logout',
        summary: 'Cerrar sesión',
        description: 'Revoca el token Sanctum usado en la petición.',
        tags: ['Auth'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Sesión cerrada'),
            new OA\Response(response: 401, description: 'No autenticado'),
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada.']);
    }

    #[OA\Get(
        path: '/api/user',
        summary: 'Obtener el usuario autenticado',
        description: 'Devuelve los datos del usuario propietario del token Bearer enviado.',
        tags: ['Auth'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuario autenticado',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(response: 401, description: 'No autenticado'),
        ]
    )]
    public function user(Request $request)
    {
        return $request->user();
    }
}
