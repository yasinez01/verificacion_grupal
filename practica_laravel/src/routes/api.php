<?php

use App\Infrastructure\Controllers\GetApiController;
use App\Infrastructure\Controllers\GetUserController;
use App\Infrastructure\Controllers\GetUsersController;
use App\Infrastructure\Controllers\GetStatusController;
use Illuminate\Support\Facades\Route;

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


Route::get('/status', GetStatusController::class);
Route::get('/user/{userEmail}', GetUserController::class);
Route::get('/user/early-adopter/{userEmail}', GetApiController::class);
Route::get('/users', GetUsersController::class);

