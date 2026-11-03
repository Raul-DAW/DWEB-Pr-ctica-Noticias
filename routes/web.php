<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\ComentarioController;


Route::get('/', function () {
    return view('index');
});

Route::resource('noticia', NoticiaController::class)->parameters(['noticia' => 'noticia']);
Route::resource('comentario', ComentarioController::class);
