<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DireccionUsuarioController;

Route::get('/getcategorias', [CategoriaController::class, 'index']);

Route::get('/getdireccionesusuario',[DireccionUsuarioController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);

