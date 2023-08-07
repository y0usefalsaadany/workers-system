<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, ClientAuthController, ClientOrderController, PostController, WorkerAuthController, WorkerReviewController};
use App\Http\Controllers\AdminDashboard\AdminNotificationController;
use App\Http\Controllers\AdminDashboard\PostStatusController;
use App\Http\Controllers\AdminDashboard\SmsNotificationController;

Route::prefix('auth')->group(function () {

    Route::controller(AdminController::class)->prefix('admin')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
    });

    Route::controller(WorkerAuthController::class)->prefix('worker')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
        Route::get('/verify/{token}', 'verify');
    });

    Route::controller(ClientAuthController::class)->prefix('client')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
    });
});
Route::get('/unauthorized', function () {
    return response()->json([
        "message" => "Unauthorized"
    ], 401);
})->name('login');


Route::controller(PostController::class)->prefix('worker/post')->group(function () {
    Route::post('/add', 'store')->middleware('auth:worker');
    Route::get('/show', 'index')->middleware('auth:admin');
    Route::get('/approved', 'approved');
});


Route::prefix('worker')->group(function () {
    Route::get('pendeing/orders', [ClientOrderController::class, 'workerOrder'])->middleware('auth:worker');
    Route::put('update/order/{id}', [ClientOrderController::class, 'update'])->middleware('auth:worker');
    Route::post('/review', [WorkerReviewController::class, 'store'])->middleware('auth:client');
    Route::get('/review/post/{postId}', [WorkerReviewController::class, 'postRate']);
});


Route::prefix('admin')->group(function () {
    Route::controller(PostStatusController::class)->prefix('/post')->group(function () {
        Route::post('/status', 'changeStatus');
    });
    Route::controller(AdminNotificationController::class)
        ->middleware('auth:admin')
        ->prefix('admin/notifications')->group(function () {
            Route::get('/all', 'index');
            Route::get('/unread', 'unread');
            Route::post('/markReadAll', 'markReadAll');
            Route::delete('/deleteAll', 'deleteAll');
            Route::delete('/delete/{id}', 'delete');
        });
});

Route::prefix('client')->group(function () {
    Route::controller(ClientOrderController::class)->prefix('/order')->group(function () {
        Route::post('/request', 'addOrder')->middleware('auth:client');
    });
});
