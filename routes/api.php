<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class)->names([
        'index' => 'api.users.index',
        'show' => 'api.users.show',
        'store' => 'api.users.store',
        'update' => 'api.users.update',
        'destroy' => 'api.users.destroy',
    ]);
    Route::apiResource('roles', RoleController::class)->names([
        'index' => 'api.roles.index',
        'show' => 'api.roles.show',
        'store' => 'api.roles.store',
        'update' => 'api.roles.update',
        'destroy' => 'api.roles.destroy',
    ]);
    Route::apiResource('permissions', PermissionController::class)->names([
        'index' => 'api.permissions.index',
        'show' => 'api.permissions.show',
        'store' => 'api.permissions.store',
        'update' => 'api.permissions.update',
        'destroy' => 'api.permissions.destroy',
    ]);
    Route::get('/user/profile', [ProfileController::class, 'profile']);
});


