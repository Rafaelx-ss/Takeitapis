@php
    $apis = [
        [
            'title' => 'GET - Listar Categorías',
            'url' => '/api/getcategorias',
            'description' => 'Este endpoint devuelve una lista de todas las categorías.',
        ],

    ];
@endphp

@foreach ($apis as $api)
    <x-card-api
        title="{{ $api['title'] }}"
        url="{{ $api['url'] }}"
        description="{{ $api['description'] }}"
    />
@endforeach
