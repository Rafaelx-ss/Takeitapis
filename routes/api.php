<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CategoriaController,
    DireccionUsuarioController,
    PaisController,
    EstadoController,
    EventoController,
    PatrocinadorController,
};

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});



Route::prefix('categorias')->group(function () {
    Route::get('', [CategoriaController::class, 'index']);
    Route::get('form', [CategoriaController::class, 'form']);
    Route::get('subcategoria/{categoriaID}', [CategoriaController::class, 'subcategoria']);
    Route::get('get/{id}', [CategoriaController::class, 'show']);
    Route::post('post/', [CategoriaController::class, 'store']);
    Route::put('put/{id}', [CategoriaController::class, 'update']);
    Route::delete('delete/{id}', [CategoriaController::class, 'destroy']);
    Route::get('/filtrar', [CategoriaController::class, 'filter']);
    Route::patch('/{id}/toggle', [CategoriaController::class, 'toggle']);
});


Route::prefix('paises')->group(function () {
    Route::get('get/', [PaisController::class, 'index']);
    Route::post('post/', [PaisController::class, 'store']);
    Route::get('get/{id}', [PaisController::class, 'show']);
    Route::put('put/{id}', [PaisController::class, 'update']);
    Route::delete('delete/{id}', [PaisController::class, 'destroy']);
    Route::get('/filtrar', [PaisController::class, 'filter']);
    Route::patch('/{id}/toggle', [PaisController::class, 'toggle']);
});

Route::prefix('estados')->group(function () {
    Route::get('', [EstadoController::class, 'index']);
    Route::post('post/', [EstadoController::class, 'store']);
    Route::get('get/{id}', [EstadoController::class, 'show']);
    Route::put('put/{id}', [EstadoController::class, 'update']);
    Route::delete('delete/{id}', [EstadoController::class, 'destroy']);
    Route::get('/filtrar', [EstadoController::class, 'filter']);
    Route::patch('/{id}/toggle', [EstadoController::class, 'toggle']);
});

Route::prefix('eventos')->group(function () {
    Route::get('/miseventos/{usuarioID}', [EventoController::class, 'miseventos']);
    Route::post('crear/{usuarioID}', [EventoController::class, 'store']);

    Route::get('get/', [EventoController::class, 'index']);
    Route::get('get/{id}', [EventoController::class, 'show']);
    Route::put('put/{id}', [EventoController::class, 'update']);
    Route::delete('delete/{id}', [EventoController::class, 'destroy']);
    Route::get('/filtrar', [EventoController::class, 'filter']);
    Route::patch('/{id}/toggle', [EventoController::class, 'toggle']);
});

Route::prefix('patrocinadores')->group(function () {
    Route::get('{usuarioID}', [PatrocinadorController::class, 'index']);
    Route::delete('delete/{id}', [PatrocinadorController::class, 'destroy']);
    
    Route::post('post/', [PatrocinadorController::class, 'store']);
    Route::get('get/{id}', [PatrocinadorController::class, 'show']);
    Route::put('put/{id}', [PatrocinadorController::class, 'update']);
    Route::get('/filtrar', [PatrocinadorController::class, 'filter']);
    Route::patch('/{i}/toggle', [PatrocinadorController::class, 'toggle']);
});

Route::get('/getdireccionesusuario',[DireccionUsuarioController::class, 'index']);
