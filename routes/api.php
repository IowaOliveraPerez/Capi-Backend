<?php

use App\Http\Controllers\ContactoController;
use Illuminate\Support\Facades\Route;

Route::get('/contactos',[ContactoController::class,'index']);
Route::get('/contactos/{id}',[ContactoController::class,'show']);
Route::post('/contactos',[ContactoController::class,'store']);
Route::put('/contactos/{id}',[ContactoController::class,'update']);
Route::delete('/contactos/{id}',[ContactoController::class,'destroy']);
