<?php

namespace App\Http\Controllers;

use App\Models\ApiEndpoint;
use Illuminate\Http\Request;

class ApiDocumentationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $endpoints = collect([
            [
                'name' => 'Obtener Todas las Categorías',
                'method' => 'GET',
                'endpoint' => '/api/getcategorias',
                'description' => 'Obtiene todas las categorías de eventos disponibles.',
                'parameters' => [],
                'headers' => [],
                'response_example' => [
                    [
                        'categoriaID' => 1,
                        'nombreCategoria' => 'Deportes',
                        'descripcionCategoria' => 'Eventos y competencias deportivas de distintos niveles y disciplinas',
                        'activoCategoria' => true,
                        'estadoCategoria' => true,
                        'created_at' => '2024-11-26T19:39:26.000000Z',
                        'updated_at' => '2024-11-26T19:39:26.000000Z'
                    ],
                    [
                        'categoriaID' => 2,
                        'nombreCategoria' => 'Arte',
                        'descripcionCategoria' => 'Eventos artísticos como exposiciones, presentaciones y talleres',
                        'activoCategoria' => true,
                        'estadoCategoria' => true,
                        'created_at' => '2024-11-26T19:39:26.000000Z',
                        'updated_at' => '2024-11-26T19:39:26.000000Z'
                    ]
                ]
            ],
            [
                'name' => 'Registro de Usuario',
                'method' => 'POST',
                'endpoint' => '/api/register',
                'description' => 'Registra un nuevo usuario en el sistema con los datos proporcionados.',
                'parameters' => [
                    'nombreUsuario' => [
                        'type' => 'string',
                        'description' => 'Nombre completo del usuario. Mínimo 2 caracteres. Obligatorio.',
                    ],
                    'usuario' => [
                        'type' => 'string',
                        'description' => 'Nombre de usuario único. Mínimo 4 caracteres. Obligatorio.',
                    ],
                    'correoUsuario' => [
                        'type' => 'string',
                        'description' => 'Correo electrónico único del usuario. Debe ser un correo válido. Obligatorio.',
                    ],
                    'contrasena' => [
                        'type' => 'string',
                        'description' => 'Contraseña del usuario. Mínimo 6 caracteres. Obligatorio.',
                    ],
                    'telefonoUsuario' => [
                        'type' => 'string',
                        'description' => 'Teléfono del usuario. Opcional.',
                    ],
                    'fechaNacimientoUsuario' => [
                        'type' => 'string',
                        'description' => 'Fecha de nacimiento del usuario en formato YYYY-MM-DD. Opcional.',
                    ],
                    'generoUsuario' => [
                        'type' => 'string',
                        'description' => 'Género del usuario: MASCULINO, FEMENINO, OTRO. Opcional.',
                    ],
                    'rolUsuario' => [
                        'type' => 'string',
                        'description' => 'Rol del usuario: participante u organizador. Obligatorio.',
                    ],
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'response_example' => [
                    'success' => true,
                    'message' => 'Usuario registrado exitosamente',
                    'data' => [
                        'id' => 1,
                        'nombreUsuario' => 'Juan Pérez',
                        'usuario' => 'juanperez',
                        'correoUsuario' => 'juanperez@example.com',
                        'telefonoUsuario' => null,
                        'fechaNacimientoUsuario' => '1990-01-01',
                        'generoUsuario' => 'MASCULINO',
                        'rolUsuario' => 'participante',
                        'created_at' => '2024-11-26T16:00:00Z',
                        'updated_at' => '2024-11-26T16:00:00Z',
                    ],
                ],
                'error_responses' => [
                    '400' => [
                        'message' => 'Datos de registro inválidos',
                        'errors' => [
                            'usuario' => ['El usuario ya existe.'],
                            'correoUsuario' => ['El correo ya está en uso.'],
                        ],
                    ],
                    '500' => [
                        'message' => 'Error al crear la cuenta',
                    ],
                ],
            ],
        ])->map(function ($item) {
            return (object) $item;
        });

        if ($request->ajax()) {
            $filteredEndpoints = $this->filterEndpoints($endpoints, $search);
            return response()->json($filteredEndpoints);
        }

        if ($search) {
            $endpoints = $this->filterEndpoints($endpoints, $search);
        }

        return view('welcome', compact('endpoints', 'search'));
    }

    private function filterEndpoints($endpoints, $search)
    {
        if (!$search) {
            return $endpoints;
        }

        $search = mb_strtolower(trim($search));

        return $endpoints->filter(function ($endpoint) use ($search) {
            $searchableText = mb_strtolower(implode(' ', [
                $endpoint->name,
                $endpoint->endpoint,
                $endpoint->description,
                $endpoint->method
            ]));

            foreach (explode(' ', $search) as $term) {
                if (!str_contains($searchableText, $term)) {
                    return false;
                }
            }

            return true;
        });
    }
}
