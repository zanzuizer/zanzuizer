<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthApiController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    // Public routes
    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('forgot-password', [AuthApiController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthApiController::class, 'resetPassword']);

    // Protected routes
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthApiController::class, 'logout']);
        Route::post('refresh', [AuthApiController::class, 'refresh']);
        Route::get('me', [AuthApiController::class, 'me']);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
