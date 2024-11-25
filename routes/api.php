<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Test route is working']);
});


Route::group(['middleware' => ['cors']], function () {
    //Aca declaras tus rutas

    Route::get('/getcategorias', [CategoriaController::class, 'index']);


    Route::post('/register', [AuthController::class, 'register']);

});
