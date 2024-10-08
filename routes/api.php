<?php

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\OTPController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PincodesController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerAddressController;

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



Route::post('/otp/send', [OTPController::class, 'send_otp']);
Route::post('/otp/verify', [OTPController::class, 'verify_otp']);
Route::post('/user/verify', [OTPController::class, 'verify_user']);

// products
Route::get('/products', [ProductController::class, 'getproducts']);
Route::get('/product/{pid}', [ProductController::class, 'getitem']);

// categories
Route::get('/categories', [CategoryController::class, 'getcategories']);
Route::get('/category/{id}', [CategoryController::class, 'getcategory']);

// subcategories

// search
Route::get('/search', [ProductController::class, 'search_item']);

Route::middleware('customer')->group(function () {
    Route::get('/authenticate', [CustomerController::class, 'authenticate']);
    Route::get('/cart', [CartItemController::class, 'get_items']);
    Route::get('/cart/add-item/{product}', [CartItemController::class, 'add_item']);
    Route::get('/cart/remove-item/{cartItem}', [CartItemController::class, 'remove_item']);
    Route::post('/cart/update-item/{cartItem}', [CartItemController::class, 'update_item']);
    Route::get('/cart/clear', [CartItemController::class, 'clear_cart']);
    Route::get('/address/{address}/activate', [CustomerAddressController::class, 'activate']);
    Route::get('/deliveryaddresses', [CustomerAddressController::class, 'get_addresses']);
    Route::post('/deliveryaddress/store', [CustomerAddressController::class, 'store']);
    Route::put('/deliveryaddress/{address}/update', [CustomerAddressController::class, 'update']);
    Route::post('/prescription/upload', [PrescriptionController::class, 'prescription_upload']);
    Route::get('/prescription/getPendingItem', [PrescriptionController::class, 'get_pending_item']);
    Route::post('/order/place', [OrderController::class, 'place']);
    Route::get('/orders', [OrderController::class, 'get_orders']);
});

Route::get('/pin/check', [PincodesController::class, 'pin_check']);
Route::post('/sendotp', [CustomerLoginController::class, 'sendOTP']);
Route::post('/verifyotp', [CustomerLoginController::class, 'verifyOTP']);
