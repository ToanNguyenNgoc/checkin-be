<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;

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

    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('role:admin')->get('/admin', function () {

});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/test', [TestController::class, 'testRedis']);

    /* USER */
    Route::get('/self', [UserController::class, 'user']);
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:user:view');
    Route::get('/user/{id}', [UserController::class, 'detail'])->middleware('permission:user:view');

    /* COMPANY */
    Route::get('/companys', [CompanyController::class, 'index'])->middleware('permission:company:view');
    Route::get('/company/{id}', [CompanyController::class, 'detail'])->middleware('permission:company:view');
    Route::post('/company/store', [CompanyController::class, 'store'])->middleware('permission:company:create');
    Route::post('/company/assign-company', [CompanyController::class, 'assignCompany'])->middleware('permission:company:create');
    Route::delete('/company/delete/{id}', [CompanyController::class, 'remove'])->middleware('permission:company:delete');

    /* EVENT */
    Route::get('/events', [EventController::class, 'index'])->middleware('permission:event:view');
    Route::get('/event/{id}', [EventController::class, 'detail'])->middleware('permission:event:view');
    Route::post('/event/store', [EventController::class, 'store'])->middleware('permission:event:create');
    Route::post('/event/assign-company', [EventController::class, 'assignCompany'])->middleware('permission:event:assign-company');
    Route::delete('/event/delete/{id}', [EventController::class, 'remove'])->middleware('permission:event:delete');
    /* FIELDS */
    Route::get('/event/{id}/fields', [EventController::class, 'getFieldTemplate'])->middleware('permission:event:config');
    Route::post('/event/{id}/field/update', [EventController::class, 'updateFieldTemplate'])->middleware('permission:event:config');

    /* ROLE */
    Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:user_role:view');
    Route::post('/role/store', [RoleController::class, 'store'])->middleware('permission:user_role:create');
    Route::post('/role/assign', [RoleController::class, 'assign'])->middleware('permission:user_role:assign-to-user');

    /* PERMISSION */
    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('permission:user_permission:view');
    Route::get('/permissions/self', [PermissionController::class, 'getListFromCurrentUser'])->middleware('permission:user_permission:view');
    Route::get('/permissions/role/{roleId}', [PermissionController::class, 'getListFromRole'])->middleware('permission:user_permission:view');
    Route::post('/permission/assign', [PermissionController::class, 'assignToRole'])->middleware('permission:user_permission:assign-to-role');
});
