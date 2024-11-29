<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\{
    CategoriaController,
    DireccionUsuarioController,
    PaisController,
};

Route::prefix('categorias')->group(function () {
    Route::get('get/', [CategoriaController::class, 'index']);

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
});

Route::get('/getdireccionesusuario',[DireccionUsuarioController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);

