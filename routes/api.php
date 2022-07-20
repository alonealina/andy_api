<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\FoodController;
use App\Http\Controllers\Api\V1\StoreCategoryController;
use App\Http\Controllers\Api\V1\StoreController;
use App\Http\Controllers\Api\V1\DrinkController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\InformationController;
use App\Http\Controllers\Api\V1\OrderDetailController;
use App\Http\Controllers\Api\V1\CastController;
use App\Http\Controllers\Api\V1\DrinkCategoryController;
use App\Http\Controllers\Api\V1\BranchController;
use App\Http\Controllers\Api\V1\OrderController;
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
Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware:auth'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    });
});

Route::group(['middleware' => 'auth', 'prefix' => 'v1', 'missing' => 'responseDataNotFound'], function () {
    Route::prefix('store-categories')->group(function () {
        Route::get('/', [StoreCategoryController::class, 'index']);
        Route::post('/', [StoreCategoryController::class, 'store'])->middleware('role:ADMIN');
    });

    Route::prefix('stores')->group(function () {
        Route::get('/', [StoreController::class, 'index']);
        Route::get('/{store}', [StoreController::class, 'show']);
        Route::get('/{store}/system-information', [StoreController::class, 'getSystemInformation']);
        Route::middleware('role:ADMIN')->group(function () {
            Route::post('/', [StoreController::class, 'store']);
            Route::post('/{store}', [StoreController::class, 'update']);
            Route::post('/{store}/delete', [StoreController::class, 'destroy']);
            Route::post('/{store}/system-information', [StoreController::class, 'updateSystemInformation']);
        });
    });

    Route::prefix('foods')->group(function () {
        Route::get('/', [FoodController::class, 'index']);
        Route::get('/default-images', [FoodController::class, 'getImageDefault']);
        Route::get('/{food}', [FoodController::class, 'show']);
        Route::middleware('role:ADMIN')->group(function () {
            Route::post('/', [FoodController::class, 'store']);
            Route::post('/{food}', [FoodController::class, 'update']);
            Route::post('/{food}/delete', [FoodController::class, 'destroy']);
        });
    });

    Route::prefix('drinks')->group(function () {
        Route::get('/', [DrinkController::class, 'index']);
        Route::get('/default-images', [DrinkController::class, 'getImageDefault']);
        Route::get('/{drink}', [DrinkController::class, 'show']);
        Route::middleware('role:ADMIN')->group(function () {
            Route::post('/', [DrinkController::class, 'store']);
            Route::post('/{drink}', [DrinkController::class, 'update']);
            Route::post('/{drink}/delete', [DrinkController::class, 'destroy']);
        });
    });

    Route::prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'index']);
        Route::middleware('role:ADMIN')->group(function () {
            Route::post('/', [NewsController::class, 'store']);
            Route::post('/{news}', [NewsController::class, 'update']);
            Route::post('/{news}/delete', [NewsController::class, 'destroy']);
        });
    });

    Route::prefix('information')->group(function () {
        Route::get('/', [InformationController::class, 'index']);
        Route::get('/{information}', [InformationController::class, 'show']);
        Route::middleware('role:ADMIN')->group(function () {
            Route::post('/', [InformationController::class, 'store']);
            Route::post('/{information}', [InformationController::class, 'update']);
            Route::post('/{information}/delete', [InformationController::class, 'destroy']);
        });
    });

    Route::prefix('casts')->group(function () {
        Route::get('/', [CastController::class, 'index']);
        Route::get('/{cast}', [CastController::class, 'show']);
        Route::get('/{cast}/schedules', [CastController::class, 'getSchedule']);
        Route::post('/{cast}/schedules', [CastController::class, 'updateSchedule'])->middleware('role:ADMIN,CAST');
        Route::middleware('role:ADMIN')->group(function () {
            Route::post('/', [CastController::class, 'store']);
            Route::post('/{cast}', [CastController::class, 'update']);
            Route::post('/{cast}/delete', [CastController::class, 'destroy']);
        });
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/pending', [OrderController::class, 'getListPending']);
    });

    Route::prefix('order-details')->group(function () {
        Route::get('/', [OrderDetailController::class, 'index']);
        Route::post('/', [OrderDetailController::class, 'store'])->middleware('role:CUSTOMER');
        Route::post('/{orderDetail}', [OrderDetailController::class, 'update'])->middleware('role:ADMIN');;
    });

    Route::prefix('drink-categories')->group(function () {
        Route::get('/', [DrinkCategoryController::class, 'index']);
        Route::get('/{drinkCategory}', [DrinkCategoryController::class, 'show']);
    });

    Route::prefix('branches')->middleware('role:SUPER_ADMIN')->group(function (){
        Route::get('/', [BranchController::class, 'index']);
        Route::post('/', [BranchController::class, 'store']);
        Route::get('/{branch}', [BranchController::class, 'show']);
        Route::post('/{branch}', [BranchController::class, 'update']);
        Route::post('/{branch}/delete', [BranchController::class, 'destroy']);
    });
});
