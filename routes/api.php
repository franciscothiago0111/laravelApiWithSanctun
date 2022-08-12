<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function(){
  
    Route::get('/products/search/{name}', [ProductController::class, 'search']);
    Route::get('/products/{id}', [ProductController::class, 'show']);   
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/users/token/create', [AuthController::class, 'createTokenReadAndWrite']);
    Route::post('/logout', [AuthController::class, 'logout']); 
});

Route::group(['middleware' => ['auth:sanctum','check.request']], function(){
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);  
    Route::post('/products', [ProductController::class, 'store']);
});

Route::fallback(function (){
    abort(404, 'API resource not found');
});


