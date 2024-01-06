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
    /* USER */
    Route::get('/self', [App\Http\Controllers\Api\UserController::class, 'user']);
    Route::get('/user/{id}', [App\Http\Controllers\Api\UserController::class, 'detail']);
    // Route::get('/users', [App\Http\Controllers\Api\UserController::class, 'index']);

    /* ROLE */
    Route::get('/roles', [App\Http\Controllers\Api\RoleController::class, 'index'])->middleware('permission:user_role_management:view');
    Route::post('/role/store', [App\Http\Controllers\Api\RoleController::class, 'store'])->middleware('permission:user_role_management:create');
    Route::post('/role/assign', [App\Http\Controllers\Api\RoleController::class, 'assign'])->middleware('permission:user_role_management:assign-roles');

    /* PERMISSION */
    Route::get('/permissions/current-user', [App\Http\Controllers\Api\PermissionController::class, 'getListFromCurrentUser'])->middleware('permission:list role');
    Route::get('/permissions/role/{roleId}', [App\Http\Controllers\Api\PermissionController::class, 'getListFromRole'])->middleware('permission:list role');
    Route::post('/permission/store', [App\Http\Controllers\Api\PermissionController::class, 'store'])->middleware('permission:create permission');
    Route::post('/permission/assign', [App\Http\Controllers\Api\PermissionController::class, 'assignToRole'])->middleware('permission:assign permission to role');
    Route::delete('/permission/revoke/{userId}', [App\Http\Controllers\Api\PermissionController::class, 'revokePermissionFromRole'])->middleware('permission:revoke permission from role');
});
