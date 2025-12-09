<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

    Route::controller(HomeController::class)->group(function(){
        Route::get('/categories' , 'get_categories');
        Route::get('/products'   , 'index');
    });

    Route::controller(CartController::class)->group(function(){
        Route::get('/cart' , 'index');
        Route::post('/cart/store' , 'store');
        Route::delete('/cart/item/{item_id}/delete' , 'destroy');
        Route::put('/cart/item/{item_id}/increment' , 'increment');
        Route::put('/cart/item/{item_id}/decrement' , 'decrement');
        Route::post('/cart/item/{item_id}/add-option', 'store_option');
        Route::delete('/cart/item/options/{option_id}/delete', 'destroy_option');
        Route::get('/order-summary' , 'checkout');
        Route::get('/payment_methods'   , 'payment_method');
    });

    Route::controller(OrderController::class)->group(function(){
        Route::get('/orders'   , 'index');
        Route::post('/order/store'   , 'store');
        Route::post('/orders/{order_id}/pay'   , 'pay');
        Route::get('/orders/{order_id}/show'   , 'show');
    });

    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile' , 'index');
        Route::post('/profile/update' , 'update');
        Route::post('/profile/password/update/' , 'update_password');
    });

    Route::controller(CouponController::class)->prefix('coupons')->group(function(){
        Route::post('/apply' , 'apply');
        Route::delete('/remove' , 'delete');
    });
});
