<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
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



Route::post('/login',[AuthController::class,'login']);
Route::get('/get-divisions',[LocationController::class,'getDivisions']);
Route::get('/get-districtData',[LocationController::class,'getDistrictData']);
Route::get('/get-districts/{division_id}',[LocationController::class,'getDistricts']);
Route::get('/get-areas/{district_id}',[LocationController::class,'getAreas']);
Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/get-all-category',[CategoryController::class,'getAllCategory']);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('subcategory', SubCategoryController::class);
    Route::apiResource('brand', BrandController::class);
    Route::apiResource('supplier', SupplierController::class);
    Route::apiResource('attribute', AttributeController::class);
    Route::apiResource('attribute-value', AttributeValueController::class);
});

