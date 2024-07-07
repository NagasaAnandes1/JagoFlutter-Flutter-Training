<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//AuthController Start

//user register
Route::post('/user/register', [App\Http\Controllers\Api\AuthController::class, 'userRegister']);

//restaurant register
Route::post('/restaurant/register', [App\Http\Controllers\Api\AuthController::class, 'restaurantRegister']);

//driver register
Route::post('/driver/register', [App\Http\Controllers\Api\AuthController::class, 'driverRegister']);

//login
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

//logout
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');

//update latlong
Route::put('/user/update-latlong', [App\Http\Controllers\Api\AuthController::class, 'updateLatLong'])->middleware('auth:sanctum');

//get all users
Route::get('/all-user', [App\Http\Controllers\Api\AuthController::class, 'getAllUser']);

//get all driver
Route::get('/all-driver', [App\Http\Controllers\Api\AuthController::class, 'getAllDriver']);

//get all restaurant
Route::get('/all-restaurant', [App\Http\Controllers\Api\AuthController::class, 'getAllRestaurant']);

//delete user
Route::delete('/user/delete/{id}', [App\Http\Controllers\Api\AuthController::class, 'deleteUser']);

//AuthController End


//ProductController auto route
Route::apiResource('/products', App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');


// OrderController Start

//create order
Route::post('/order', [App\Http\Controllers\Api\OrderController::class, 'createOrder'])->middleware('auth:sanctum');

//get order by user id
Route::get('/order/user/', [App\Http\Controllers\Api\OrderController::class, 'orderHistory'])->middleware('auth:sanctum');

//get order by restaurant id
Route::get('/order/restaurant/', [App\Http\Controllers\Api\OrderController::class, 'getOrderByStatus'])->middleware('auth:sanctum');

//get order by driver id
Route::get('/order/driver/', [App\Http\Controllers\Api\OrderController::class, 'getOrderStatusByDriver'])->middleware('auth:sanctum');

//update order status by restaurant
Route::put('/order/restaurant/update-status/{id}', [App\Http\Controllers\Api\OrderController::class, 'updateOrderStatus'])->middleware('auth:sanctum');

//update order status
Route::put('/order/driver/update-status/{id}', [App\Http\Controllers\Api\OrderController::class, 'updateOrderStatusByDriver'])->middleware('auth:sanctum');

//update purchase status
Route::put('/order/user/update-status/{id}', [App\Http\Controllers\Api\OrderController::class, 'updatePurchaseStatus'])->middleware('auth:sanctum');

//OrderController End
