<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;

Route::get('/getcategorias', [CategoriaController::class, 'index']);


Route::post('/register', [AuthController::class, 'register']);
