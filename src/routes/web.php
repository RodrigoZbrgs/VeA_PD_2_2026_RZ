<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;

Route::get('/', [HomeController::class, 'index']);

// Artist adresses
Route::get('/artists', [ArtistController::class,'list']);
Route::get('/artists/create', [ArtistController::class, 'create']);
Route::post('/artists/put', [ArtistController::class, 'put']);
Route::get('/artists/update/{artist}', [ArtistController::class, 'update']);
Route::post('/artists/patch/{artist}', [ArtistController::class, 'patch']);
Route::post('/artists/delete/{artist}', [ArtistController::class, 'delete']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

Route :: get ( '/albums' , [ AlbumController :: class , 'list' ]); 
Route :: get ( '/albums/create' , [ AlbumController :: class , 'create' ]); 
Route :: post ( '/albums/put' , [ AlbumController :: class , 'put' ]); 
Route :: get ( '/albums/update/{album}' , [ AlbumController :: class , 'update' ]); 
Route :: post ( '/albums/patch/{album}' , [ AlbumController :: class , 'patch' ]); 
Route :: post ( '/albums/delete/{album}' , [ AlbumController :: class , 'delete' ]); 