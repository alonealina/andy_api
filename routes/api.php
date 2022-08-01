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
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\FoodCategoryController;
use App\Http\Controllers\Api\V1\BackgroundController;
use App\Http\Controllers\Api\V1\SystemInformationController;
use App\Http\Controllers\Api\V1\TurnoverController;
use App\Http\Controllers\Api\V1\NotificationController;
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

    Route::middleware('check_maintain')->group(function () {
        Route::prefix('store-categories')->group(function () {
            Route::get('/', [StoreCategoryController::class, 'index']);
            Route::post('/', [StoreCategoryController::class, 'store'])->middleware('role:ADMIN');
        });

        Route::prefix('accounts')->group(function () {
            Route::middleware('role:ADMIN')->group(function () {
                Route::get('/', [AccountController::class, 'index']);
                Route::get('/{account}', [AccountController::class, 'show']);
                Route::post('/', [AccountController::class, 'store']);
                Route::post('/{account}', [AccountController::class, 'update']);
                Route::post('/{account}/delete', [AccountController::class, 'destroy']);
            });
        });

        Route::prefix('stores')->middleware('role:ADMIN,CUSTOMER')->group(function () {
            Route::get('/', [StoreController::class, 'index']);
            Route::get('/{store}', [StoreController::class, 'show']);
            Route::middleware('role:ADMIN')->group(function () {
                Route::post('/', [StoreController::class, 'store']);
                Route::post('/{store}', [StoreController::class, 'update']);
                Route::post('/{store}/delete', [StoreController::class, 'destroy']);
            });
        });

        Route::prefix('system-information')->middleware('role:ADMIN,CUSTOMER')->group(function () {
            Route::get('/', [SystemInformationController::class, 'getSystemInformation']);
            Route::post('/', [SystemInformationController::class, 'updateSystemInformation'])->middleware('role:ADMIN');
        });

        Route::prefix('foods')->middleware('role:ADMIN,CUSTOMER')->group(function () {
            Route::get('/', [FoodController::class, 'index']);
            Route::middleware('role:ADMIN')->group(function () {
                Route::get('/default-images', [FoodController::class, 'getImageDefault']);
                Route::post('/', [FoodController::class, 'store']);
                Route::post('/{food}', [FoodController::class, 'update']);
                Route::post('/{food}/delete', [FoodController::class, 'destroy']);
            });
            Route::get('/{food}', [FoodController::class, 'show']);
        });

        Route::prefix('drinks')->middleware('role:ADMIN,CUSTOMER')->group(function () {
            Route::get('/', [DrinkController::class, 'index']);
            Route::middleware('role:ADMIN')->group(function () {
                Route::get('/default-images', [DrinkController::class, 'getImageDefault']);
                Route::post('/', [DrinkController::class, 'store']);
                Route::post('/{drink}', [DrinkController::class, 'update']);
                Route::post('/{drink}/delete', [DrinkController::class, 'destroy']);
            });
            Route::get('/{drink}', [DrinkController::class, 'show']);
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
                Route::post('/{cast}/account', [CastController::class, 'updateAccount']);
                Route::post('/{cast}/delete', [CastController::class, 'destroy']);
            });
        });

        Route::prefix('orders')->middleware('role:ADMIN,CUSTOMER')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->middleware('role:ADMIN');
            Route::get('/history', [OrderController::class, 'getHistory'])->middleware('role:CUSTOMER');
            Route::post('/{order}', [OrderController::class, 'update']);
        });

        Route::prefix('order-details')->group(function () {
            Route::post('/', [OrderDetailController::class, 'store'])->middleware('role:CUSTOMER');
            Route::middleware('role:ADMIN')->group(function () {
                Route::get('/pending', [OrderDetailController::class, 'getListPending']);
                Route::get('/new', [OrderDetailController::class, 'getNewOrder']);
                Route::post('/{orderDetail}', [OrderDetailController::class, 'update']);
            });
        });

        Route::prefix('drink-categories')->group(function () {
            Route::get('/', [DrinkCategoryController::class, 'index']);
            Route::post('/', [DrinkCategoryController::class, 'store'])->middleware('role:ADMIN');
            Route::get('/{drinkCategory}', [DrinkCategoryController::class, 'show']);
            Route::post('/{drinkCategory}', [DrinkCategoryController::class, 'update'])->middleware('role:ADMIN');
            Route::post('/{drinkCategory}/delete', [DrinkCategoryController::class, 'destroy'])->middleware('role:ADMIN');
        });

        Route::prefix('food-categories')->middleware('role:ADMIN,CUSTOMER')->group(function () {
            Route::get('/', [FoodCategoryController::class, 'index']);
            Route::get('/{foodCategory}', [FoodCategoryController::class, 'show']);
            Route::middleware('role:ADMIN')->group(function () {
                Route::post('/', [FoodCategoryController::class, 'store']);
                Route::post('/{foodCategory}', [FoodCategoryController::class, 'update']);
                Route::post('/{foodCategory}/delete', [FoodCategoryController::class, 'destroy']);
            });
        });

        Route::prefix('backgrounds')->middleware('role:ADMIN,CUSTOMER')->group(function () {
            Route::get('/', [BackgroundController::class, 'index']);
            Route::post('/', [BackgroundController::class, 'store'])->middleware('role:ADMIN');
        });

        Route::prefix('turnover')->middleware('role:ADMIN')->group(function () {
            Route::get('/total', [TurnoverController::class, 'getTurnoverTotal']);
            Route::get('/detail', [TurnoverController::class, 'getTurnoverDetail']);
        });

        Route::prefix('notifications')->middleware('role:ADMIN')->group(function () {
            Route::get('/', [NotificationController::class, 'index']);
            Route::post('/read', [NotificationController::class, 'readNotify']);
        });

        Route::post('/sos', [AccountController::class, 'callSOS'])->middleware('role:CUSTOMER');
    });

    Route::prefix('branches')->middleware('role:SUPER_ADMIN')->group(function (){
        Route::get('/', [BranchController::class, 'index']);
        Route::get('/maintain', [BranchController::class, 'getMaintain']);
        Route::post('/maintain', [BranchController::class, 'setMaintain']);
        Route::post('/', [BranchController::class, 'store']);
        Route::get('/{branch}', [BranchController::class, 'show']);
        Route::post('/{branch}', [BranchController::class, 'update']);
        Route::post('/{branch}/delete', [BranchController::class, 'destroy']);
        Route::post('/{branch}/maintain', [BranchController::class, 'setMaintainBranch']);
    });
});
