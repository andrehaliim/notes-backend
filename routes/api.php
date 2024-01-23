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

Route::group(['namespace' => 'App\Http\Controllers'], function ()
{
    Route::controller(AuthController::class)->group(function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/login', 'login')->name('auth.login')->middleware(['throttle:15,3']);
            Route::post('/me', 'me')->name('auth.me')->middleware(['auth:sanctum']);
            Route::post('/logout', 'logout')->name('auth.logout')->middleware(['auth:sanctum']);
        });
    });

});
