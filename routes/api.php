<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductPhotoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesManagerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\ProductController;
use App\Http\Resources\SalesManagerResource;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::post('/login',[AuthController::class,'login']);
Route::get('/get-divisions',[LocationController::class,'getDivisions']);
Route::get('/get-districtData',[LocationController::class,'getDistrictData']);
Route::get('/get-districts/{division_id}',[LocationController::class,'getDistricts']);
Route::get('/get-areas/{district_id}',[LocationController::class,'getAreas']);

Route::group(['middleware' => ['auth:sanctum,admin']], static function () {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/get-all-category',[CategoryController::class,'getAllCategory']);
    Route::get('/get-all-shops',[ShopController::class,'getAllShops']);
    Route::get('/get-all-brand',[BrandController::class,'getAllBrand']);
    Route::get('/get-all-country',[CountryController::class,'getAllCountry']);
    Route::get('/get-all-suppliers',[SupplierController::class,'getAllSuppliers']);
    Route::get('/get-all-attributes',[AttributeController::class,'getAllAttributes']);
    Route::get('/get-all-sub-category/{category_id}',[SubCategoryController::class,'getAllSubCategory']);
    Route::get('/get-all-customer',[CustomerController::class,'getAllCustomer']);
    Route::post('/product/photo/upload/{id}',[ProductPhotoController::class,'store']);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('subcategory', SubCategoryController::class);
    Route::apiResource('brand', BrandController::class);
    Route::apiResource('supplier', SupplierController::class);
    Route::apiResource('attribute', AttributeController::class);
    Route::apiResource('attribute-value', AttributeValueController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('shop', ShopController::class);
    Route::apiResource('sales-manager', SalesManagerController::class);
    Route::apiResource('customer', CustomerController::class);

});

Route::group(['middleware' => ['auth:admin,sales_manager']], function () {
    Route::apiResource('product', ProductController::class)->only('index','show');
    Route::apiResource('customer', CustomerController::class);
    Route::apiResource('order', OrderController::class);
    Route::get('/get-payment-methods-data',[PaymentMethodController::class,'getPaymentMethodsData']);
    Route::get('/get-all-category',[CategoryController::class,'getAllCategory']);
    Route::get('/get-all-sub-category/{category_id}',[SubCategoryController::class,'getAllSubCategory']);
    Route::get('/get-barcode-product-search',[ProductController::class,'get_barcode_product_search']);
    Route::get('/get-report',[ReportController::class,'index']);

});


Route::group(['middleware' => ['auth:sales_manager']], function () {
   // Route::apiResource('product', ProductController::class);
});

