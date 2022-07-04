<?php

use App\Http\Controllers\Api\V1\FoodController;
use App\Http\Controllers\Api\V1\UserController;
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

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    Route::resources([
        'users' => UserController::class,
        'foods' => FoodController::class
    ]);
});


