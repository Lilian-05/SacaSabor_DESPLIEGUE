<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/chicharronerias', [ApiController::class, 'chicharronerias']);
Route::get('/chicharronerias/{chicharroneria}', [ApiController::class, 'chicharroneria']);
Route::get('/chicharronerias/{chicharroneria}/productos', [ApiController::class, 'productos']);
Route::get('/categorias', [ApiController::class, 'categorias']);