<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserSettingsController;
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

Route::post('login',    [AuthController::class, 'login']);
Route::post('logout',   [AuthController::class, 'logout']);
Route::post('refresh',  [AuthController::class, 'refresh']);
Route::post('me',       [AuthController::class, 'me']);

Route::post('users', [UsersController::class, 'store']);

Route::middleware('auth:jwt')->group(function () {
    Route::get('articles',              [ArticlesController::class, 'index']);
    Route::get('user-config/{id}/show', [UserSettingsController::class, 'show']);
    Route::patch('user-config/{id}',    [UserSettingsController::class, 'update']);
});
