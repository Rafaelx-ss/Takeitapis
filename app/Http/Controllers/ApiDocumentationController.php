<?php

namespace App\Http\Controllers;

use App\Models\ApiEndpoint;
use Illuminate\Http\Request;

class ApiDocumentationController extends Controller
{
    public function index()
    {
        $endpoints = collect([
            [
                'name' => 'Obtener Perfil de Usuario',
                'method' => 'GET',
                'endpoint' => '/api/v1/usuarios/{id}',
                'description' => 'Obtiene información detallada sobre el perfil de un usuario específico, incluyendo sus preferencias y configuraciones.',
                'parameters' => [
                    'id' => [
                        'type' => 'integer',
                        'description' => 'Identificador único del usuario'
                    ],
                    'incluir' => [
                        'type' => 'string',
                        'description' => 'Lista opcional separada por comas de datos relacionados (ej: publicaciones,comentarios)'
                    ]
                ],
                'headers' => [
                    'Authorization' => 'Bearer {token}',
                    'Accept' => 'application/json'
                ],
                'response_example' => [
                    'id' => 1,
                    'nombre_usuario' => 'juan_perez',
                    'correo' => 'juan@ejemplo.com',
                    'perfil' => [
                        'nombre_completo' => 'Juan Pérez',
                        'url_avatar' => 'https://api.ejemplo.com/avatars/1.jpg',
                        'biografia' => 'Desarrollador de software y entusiasta de la tecnología'
                    ],
                    'configuracion' => [
                        'notificaciones_activas' => true,
                        'tema' => 'oscuro',
                        'idioma' => 'es'
                    ],
                    'creado_en' => '2024-01-10T15:30:00Z',
                    'actualizado_en' => '2024-01-10T15:30:00Z'
                ]
            ],
            [
                'name' => 'Crear Nuevo Pedido',
                'method' => 'POST',
                'endpoint' => '/api/v1/pedidos',
                'description' => 'Crea un nuevo pedido en el sistema con los productos especificados y detalles de envío.',
                'parameters' => [
                    'productos' => [
                        'type' => 'array',
                        'description' => 'Array de IDs de productos y cantidades'
                    ],
                    'direccion_envio' => [
                        'type' => 'object',
                        'description' => 'Detalles de la dirección de envío del cliente'
                    ],
                    'metodo_pago' => [
                        'type' => 'string',
                        'description' => 'Identificador del método de pago (ej: tarjeta, paypal)'
                    ]
                ],
                'headers' => [
                    'Authorization' => 'Bearer {token}',
                    'Content-Type' => 'application/json'
                ],
                'response_example' => [
                    'id_pedido' => 'PED-2024-001',
                    'estado' => 'pendiente',
                    'monto_total' => 2499.99,
                    'productos' => [
                        [
                            'id_producto' => 'PROD-123',
                            'nombre' => 'Auriculares Premium',
                            'cantidad' => 1,
                            'precio_unitario' => 2499.99
                        ]
                    ],
                    'direccion_envio' => [
                        'calle' => 'Av. Libertador 123',
                        'ciudad' => 'Buenos Aires',
                        'provincia' => 'CABA',
                        'codigo_postal' => '1425',
                        'pais' => 'Argentina'
                    ],
                    'detalles_pago' => [
                        'metodo' => 'tarjeta',
                        'estado' => 'autorizado'
                    ],
                    'creado_en' => '2024-01-10T16:00:00Z'
                ]
            ]
        ])->map(function ($item) {
            return (object) $item;
        });

        return view('welcome', compact('endpoints'));
    }
}
