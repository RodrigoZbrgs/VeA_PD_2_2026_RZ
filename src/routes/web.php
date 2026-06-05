<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\DataController;

Route::get('/', [HomeController::class, 'index']);

// Artist adresses
Route::get('/artists', [ArtistController::class,'list']);
Route::get('/artists/create', [ArtistController::class, 'create']);
Route::post('/artists/put', [ArtistController::class, 'put']);
Route::get('/artists/update/{artist}', [ArtistController::class, 'update']);
Route::post('/artists/patch/{artist}', [ArtistController::class, 'patch']);
Route::post('/artists/delete/{artist}', [ArtistController::class, 'delete']);

// AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

// ALBUMS
Route :: get ( '/albums' , [ AlbumController :: class , 'list' ]); 
Route :: get ( '/albums/create' , [ AlbumController :: class , 'create' ]); 
Route :: post ( '/albums/put' , [ AlbumController :: class , 'put' ]); 
Route :: get ( '/albums/update/{album}' , [ AlbumController :: class , 'update' ]); 
Route :: patch ( '/albums/patch/{album}' , [ AlbumController :: class , 'patch' ]); 
Route :: post ( '/albums/delete/{album}' , [ AlbumController :: class , 'delete' ]); 

// DATA/API
Route::get('/data/get-top-albums', [DataController::class, 'getTopAlbums']);
Route::get('/data/get-album/{album}', [DataController::class, 'getAlbum']);
Route::get('/data/get-related-albums/{album}', [DataController::class, 'getRelatedAlbums']);