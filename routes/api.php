<?php

use app\controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CategoriaController,
    DireccionUsuarioController,
    PaisController,
    EstadoController,
    EventoController,
    PatrocinadorController,
    UsuarioController,
    Qr_codeController,
    UsuarioEventosController
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
    Route::post('verificarcuenta', [AuthController::class, 'verificarcuenta']);
    Route::post('enviarcorreo', [AuthController::class, 'enviarCorreo']);
    Route::post('codigoverificacion', [AuthController::class, 'codigoverificacion']);
    Route::post('newpassword', [AuthController::class, 'newpassword']);
});

Route::get('users/page/', [UsuarioController::class, 'page']);
Route::post('users/update/{usuarioID}', [UsuarioController::class, 'update']);
Route::delete('users/delete/{usuarioID}', [UsuarioController::class, 'destroy']);
Route::get('users/get/{usuarioID}', [UsuarioController::class, 'show']);


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
    Route::get('eventosstarting/', [EventoController::class, 'eventosstarting']);
    Route::get('/miseventos/{usuarioID}', [EventoController::class, 'miseventos']);
    Route::post('crear/{usuarioID}', [EventoController::class, 'store']);
    Route::get('page/', [EventoController::class, 'page']);
    Route::get('get/{id}', [EventoController::class, 'show']);
    Route::put('actualizar/{id}', [EventoController::class, 'update']);
    Route::delete('delete/{eventoID}', [EventoController::class, 'destroy']);
    Route::get('/filtrar', [EventoController::class, 'filter']);
    Route::patch('/{id}/toggle', [EventoController::class, 'toggle']);
    Route::get('/usuario/{usuarioID}', [EventoController::class, 'usuario']);
    Route::get('/admin/{usuarioID}', [EventoController::class, 'admin']);
    Route::post('inscribirUsuario', [EventoController::class, 'inscribirUsuario']);

    
});

Route::prefix('patrocinadores')->group(function () {
    Route::get('mispatrocinadores/{usuarioID}', [PatrocinadorController::class, 'index']);
    Route::delete('delete/{id}', [PatrocinadorController::class, 'destroy']);
    Route::get('page/', [PatrocinadorController::class, 'page']);
    Route::post('post/', [PatrocinadorController::class, 'store']);
    Route::get('get/{id}', [PatrocinadorController::class, 'show']);
    Route::put('put/{id}', [PatrocinadorController::class, 'update']);
    Route::get('/filtrar', [PatrocinadorController::class, 'filter']);
    Route::patch('/{i}/toggle', [PatrocinadorController::class, 'toggle']);
});


Route::get('clear/eventosusuario', [UsuarioEventosController::class, 'eliminarEventos']);

 
Route::get('/getdireccionesusuario',[DireccionUsuarioController::class, 'index']);


Route::get('qr_codes/evento/{eventoID}/usuario/{usuarioID}', [Qr_codeController::class, 'getQrCode']);

Route::put('qr_codes/{usuarioID}/{eventoID}/finalizar', [Qr_codeController::class, 'finalizarQR']);

Route::get('qr_codesevents/{eventoID}', [Qr_codeController::class, 'contarQrEstadoCero']);

Route::get('qr_codeParticipantes/{eventoID}', [Qr_codeController::class, 'VerParticiparticipantes']);
