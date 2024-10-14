<?php

use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\StatusesController;
use App\Http\Controllers\Api\WarehousesController;
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


Route::apiResource('cities',CitiesController::class,["as"=>"api"]);
Route::put('citiesstatus',[CitiesController::class,'typestatus']);
Route::get('filter/cities/{filter}', [CitiesController::class,'filterbycountryid']);

Route::apiResource('statuses',StatusesController::class,["as"=>"api"]);
Route::get('/statusessearch',[StatusesController::class,'search']);

// php artisan route:cache (error)
// Route::apiResource('warehouses',WarehousesController::class);
// php artisan route:cache (solved)
Route::apiResource('warehouses',WarehousesController::class,["as"=>"api"]);
Route::put('warehousesstatus',[WarehousesController::class,'typestatus']);