@php
    $apis = [
        [
            'title' => 'GET - Listar Categorías',
            'url' => '/api/getcategorias',
            'description' => 'Este endpoint devuelve una lista de todas las categorías.',
            'params' => [],
        ],
        [
            'title' => 'Crear cuenta',
            'url' => '/api/register',
            'description' => 'Sirve para crear una cuenta de usuario nueva.',
            'params' => [
                'nombreUsuario = "string"',
                'usuario = "string"',
                'correoUsuario = "email"',
                'contrasena = "string"',
                'telefonoUsuario = "string"',
                'fechaNacimientoUsuario = "date"',
                'generoUsuario = "MASCULINO|FEMENINO|OTRO"',
                'rolUsuario = "participante|organizador"'
            ],
        ],
    ];
@endphp

@foreach ($apis as $api)
    <x-card-api
        title="{{ $api['title'] }}"
        url="{{ $api['url'] }}"
        description="{{ $api['description'] }}"
        :params="$api['params']"
    />
@endforeach


