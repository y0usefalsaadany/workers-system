<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\WorkerAuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => ['DbBackup'],
    'prefix' => 'auth/admin'
], function ($router) {
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::post('/refresh', [AdminController::class, 'refresh']);
    Route::get('/user-profile', [AdminController::class, 'userProfile']);
});

Route::group([
    'middleware' => ['DbBackup'],
    'prefix' => 'auth/worker'
], function ($router) {
    Route::post('/login', [WorkerAuthController::class, 'login']);
    Route::post('/register', [WorkerAuthController::class, 'register']);
    Route::post('/logout', [WorkerAuthController::class, 'logout']);
    Route::post('/refresh', [WorkerAuthController::class, 'refresh']);
    Route::get('/user-profile', [WorkerAuthController::class, 'userProfile']);
});

Route::group([
    'middleware' => ['DbBackup'],
    'prefix' => 'auth/client'
], function ($router) {
    Route::post('/login', [ClientAuthController::class, 'login']);
    Route::post('/register', [ClientAuthController::class, 'register']);
    Route::post('/logout', [ClientAuthController::class, 'logout']);
    Route::post('/refresh', [ClientAuthController::class, 'refresh']);
    Route::get('/user-profile', [ClientAuthController::class, 'userProfile']);
});
