<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\CategoryController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// For Authentication
Route::group(['prefix' => 'users', 'as' => 'users.'], function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
        Route::group(['middleware' => ['jwt.verify', 'checkTokenExpiration']], function () {
            Route::post('logout', 'logout')->name('logout');
            Route::post('refresh', 'refresh')->name('refresh');
        });
    });
});



Route::group(['middleware' => ['jwt.verify', 'checkTokenExpiration']], function () {

    // For Category
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::group(['prefix' => '/{id}'], function () {
                Route::put('update', 'update')->name('update');
                Route::delete('destroy', 'destroy')->name('destroy');
            });
        });
    });



    // For Car
    Route::group(['prefix' => 'car', 'as' => 'car.'], function () {
        Route::controller(CarController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::group(['prefix' => '/{id}'], function () {
                Route::put('update', 'update')->name('update');
                Route::delete('destroy', 'destroy')->name('destroy');
            });
        });
    });
});
