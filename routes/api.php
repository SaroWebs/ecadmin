<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OTPController;
use App\Http\Controllers\ProductController;

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


Route::get('/test', function(Request $request){
    $item = [
        'd1'=>'hello',
        'd2'=>'this is a test',
    ];
    return response()->json($item);
});

Route::post('/otp/send', [OTPController::class, 'send_otp']);
Route::post('/otp/verify', [OTPController::class, 'verify_otp']);
Route::post('/user/verify', [OTPController::class, 'verify_user']);

// products

// categories

// subcategories

// search
Route::post('/search', [ProductController::class, 'search_item']);
