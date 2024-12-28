<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


//Route::post('login', [AuthController::class, 'checklogin']);
//Route::post('register', [AuthController::class, 'register'])name('registration');
//Route::post('logout', [AuthController::class, 'logout']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
