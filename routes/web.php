<?php

use App\Http\Controllers\ApiDocumentationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApiDocumentationController::class, 'index'])->name('api-docs.index');
Route::post('/api-docs', [ApiDocumentationController::class, 'store'])->name('api-docs.store');
