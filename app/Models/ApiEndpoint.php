<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiEndpoint extends Model
{
    protected $fillable = [
        'name',
        'method',
        'endpoint',
        'description',
        'parameters',
        'headers',
        'response_example'
    ];

    protected $casts = [
        'parameters' => 'array',
        'headers' => 'array',
        'response_example' => 'array'
    ];
}
