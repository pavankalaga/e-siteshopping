<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::middleware('user')->group(function(){
    Route::get('/product/list',[ProductController::class,'index']);
    Route::post('/store',[ProductController::class,'store']);
    Route::post('/update/{product}',[ProductController::class,'update']);
    Route::post('/delete/{product}',[ProductController::class,'destroy']);
    Route::get('/show/{product}',[ProductController::class,'show']);
});

