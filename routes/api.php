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

});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/test', [App\Http\Controllers\Api\TestController::class, 'testRedis']);

    /* USER */
    Route::get('/self', [App\Http\Controllers\Api\UserController::class, 'user']);
    Route::get('/user/{id}', [App\Http\Controllers\Api\UserController::class, 'detail'])->middleware('permission:user:view');;
    Route::get('/users', [App\Http\Controllers\Api\UserController::class, 'index'])->middleware('permission:user:view');;

    /* ROLE */
    Route::get('/roles', [App\Http\Controllers\Api\RoleController::class, 'index'])->middleware('permission:user_role:view');
    Route::post('/role/store', [App\Http\Controllers\Api\RoleController::class, 'store'])->middleware('permission:user_role:create');
    Route::post('/role/assign', [App\Http\Controllers\Api\RoleController::class, 'assign'])->middleware('permission:user_role:assign-to-user');

    /* PERMISSION */
    Route::get('/permissions', [App\Http\Controllers\Api\PermissionController::class, 'index'])->middleware('permission:user_permission:view');
    Route::get('/permissions/self', [App\Http\Controllers\Api\PermissionController::class, 'getListFromCurrentUser'])->middleware('permission:user_permission:view');
    Route::get('/permissions/role/{roleId}', [App\Http\Controllers\Api\PermissionController::class, 'getListFromRole'])->middleware('permission:user_permission:view');
    Route::post('/permission/assign', [App\Http\Controllers\Api\PermissionController::class, 'assignToRole'])->middleware('permission:user_permission:assign-to-role');
    Route::delete('/permission/revoke/{roleId}', [App\Http\Controllers\Api\PermissionController::class, 'revokeFromRole'])->middleware('permission:user_permission:revoke-from-role');
});
