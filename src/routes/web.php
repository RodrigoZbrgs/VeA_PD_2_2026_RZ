<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;

Route::get('/', [HomeController::class, 'index']);

// Artist adresses
Route::get('/artists', [ArtistController::class,'list']);