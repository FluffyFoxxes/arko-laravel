<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChangeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('change')->group(function () {
    Route::post('create', [ChangeController::class, 'create']);
    Route::post('close', [ChangeController::class, 'close']);
    Route::post('add/user', [ChangeController::class, 'addUser']);
});

Route::prefix('user')->group(function () {
    Route::post('registration', [UserController::class, 'registration']);
    Route::post('login', [UserController::class, 'login']);
    Route::get('all', [UserController::class, 'all']);
    Route::post('dismissal', [UserController::class, 'dismissal']);
});

Route::prefix('order')->group(function () {
    Route::post('submit', [OrderController::class, 'submit']);
    Route::post('orders/all/user', [OrderController::class, 'allUser']);
    Route::post('status/pay', [OrderController::class, 'statusSetPay']);
    Route::post('status/abort', [OrderController::class, 'statusSetAbort']);
    Route::post('status/done', [OrderController::class, 'statusSetDone']);
    Route::get('orders/all/pay', [OrderController::class, 'allByPay']);
    Route::get('orders/all', [OrderController::class, 'all']);
    Route::post('/', [OrderController::class, 'item']);
});

Route::prefix('comment')->group(function () {
    Route::post('create', [CommentController::class, 'create']);
    Route::get('all', [CommentController::class, 'all']);
});
