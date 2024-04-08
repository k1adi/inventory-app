<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\InventoryController;
use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\LocationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'item' => ItemController::class,
    'category' => CategoryController::class,
    'location' => LocationController::class,
    'inventory' => InventoryController::class,
]);