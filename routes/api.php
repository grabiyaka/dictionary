<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetController;

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

Route::get('get/word/{word}', GetController::class);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['namespace' => 'App\Http\Controllers\Word', 'prefix' => 'word'], function () {
        Route::get('/user/{user_id}', ShowAllInUserController::class);
        Route::get('/{word}', ShowController::class);
        Route::post('/', StoreController::class);
        Route::post('/update', UpdateController::class);
        Route::delete('/{word}', DeleteController::class);
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Image', 'prefix' => 'image'], function () {
    Route::post('/', SaveAvatarController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
