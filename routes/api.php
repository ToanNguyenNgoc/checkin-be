<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function() {
    Route::get('/connect', function () {
        echo "Connected!";
    });

    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
});

Route::middleware('role:admin')->get('/admin', function () {
    // Route::post('/store', [App\Http\Controllers\Api\UserController::class, 'store']);
});

Route::middleware('permission:create users')->get('/create', function () {
    // Route::post('/store', [App\Http\Controllers\Api\UserController::class, 'store']);
});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', [App\Http\Controllers\Api\UserController::class, 'user']);
    Route::get('/users', [App\Http\Controllers\Api\UserController::class, 'index']);
    Route::get('/user/{id}', [App\Http\Controllers\Api\UserController::class, 'detail']);
});
