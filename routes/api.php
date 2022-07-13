<?php

use App\Http\Controllers\Api\V1\FoodController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\StoreCategoryController;
use App\Http\Controllers\Api\V1\StoreController;
use App\Http\Controllers\Api\V1\DrinkController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\InformationController;
use App\Http\Controllers\Api\V1\SystemInformationController;
use App\Http\Controllers\Api\V1\CastController;
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

require_once __DIR__ . '/auth.php';

Route::group(['middleware' => 'auth', 'prefix' => 'v1'], function () {
    Route::resources([
        'users' => UserController::class,
        'store-categories' => StoreCategoryController::class,
        'stores' => StoreController::class,
        'foods' => FoodController::class,
        'drinks' => DrinkController::class,
        'events' => EventController::class,
        'system-information' => SystemInformationController::class,
        'information' => InformationController::class,
        'casts' => CastController::class,
    ], [
        'only' => ['index', 'store', 'update', 'show', 'destroy'],
        'missing' => 'responseDataNotFound'
    ]);

    Route::get('casts/{cast}/schedules', [CastController::class, 'getSchedule'])->missing('responseDataNotFound');
    Route::put('casts/{cast}/schedules', [CastController::class, 'updateSchedule'])->missing('responseDataNotFound');
    Route::get('foods/default-images', [FoodController::class, 'getImageDefault']);
});
