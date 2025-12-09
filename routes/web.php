<?php

use App\Http\Controllers\Dashboard\AdminOrderController;
use App\Http\Controllers\Dashboard\CartController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PaymentMethodController;
use App\Http\Controllers\Dashboard\ProductController; 
use App\Http\Controllers\Dashboard\SideOptionController;
use App\Http\Controllers\Dashboard\ToppingController;
use App\Http\Controllers\Dashboard\UserAccountController;
use App\Http\Controllers\Dashboard\UserController; 
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;






Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function(){

Route::get('/dashboard', [HomeController::class , 'index'])->name('dashboard');

Route::controller(UserController::class)->prefix('dashboard')->group(function(){
    Route::get('/users' , 'index')->name('users.index');
    Route::post('/users/{user_id}/block'  , 'block')->name('users.block');
    Route::post('/users/{user_id}/active' , 'active')->name('users.active');
    Route::get('/users/{user_id}/show' , 'show')->name('users.show');
});

Route::controller(ProductController::class)->prefix('dashboard')->group(function(){
    Route::get('/products' , 'index')->name('products.index');
    Route::get('/products/create', 'create')->name('products.create');
    Route::post('/products/store', 'store')->name('products.store');
    Route::get('/products/{product_id}/edit', 'edit')->name('products.edit'); 
    Route::put('/products/{product_id}/update', 'update')->name('products.update'); 
    Route::delete('/products/{product_id}/delete', 'destroy')->name('products.delete'); 
    Route::get('/products/{product_id}/show', 'show')->name('products.show'); 
});
Route::controller(CartController::class)->prefix('dashboard')->group(function(){
    Route::get('/cart' , 'index')->name('cart.index');
    Route::post('/cart/store', 'store')->name('cart.store');
    Route::delete('/cart/item/{item_id}/delete' , 'destroy')->name('car_item.delete');
    Route::delete('/cart/item/options/{option_id}/delete', 'destroy_option')->name('cart_option.delete');
    Route::post('/cart/item/{item_id}/increment' , 'increment')->name('cart_item.increment');
    Route::post('/cart/item/{item_id}/decrement' , 'decrement')->name('cart_item.decrement');
    Route::get('/cart/item/{item_id}/create-option', 'create_option')->name('cart_option.create');
    Route::post('/cart/item/{item_id}/store-option', 'store_option')->name('cart_option.store');
    Route::get('/order-summary' , 'checkout')->name('order.summary');
});

Route::controller(AdminOrderController::class)->group(function(){
    Route::get('/AdminOrders'   , 'index')->name('AdminOrders.index');
    Route::post('/order/store'   , 'store')->name('order.store');
    Route::post('/order/{order_id}/pay'   , 'pay')->name('order.pay');
});

Route::controller(OrderController::class)->group(function(){
    Route::get('/orders'   , 'index')->name('orders.index');
    Route::get('/order/{order_id}/show' , 'show')->name('order.show');
});

Route::controller(PaymentMethodController::class)->prefix('payment-methods')->name('payment_method.')->group(function () {

    Route::get('/',  'index')->name('index');

    Route::get('/create', 'create')->name('create');
    Route::post('/store',  'store')->name('store');

    Route::get('/{method_id}/edit',  'edit')->name('edit');
    Route::post('/{method_id}/update', 'update')->name('update');

    Route::delete('/{method_id}/delete', 'destroy')->name('delete');
});

    Route::resource('coupons', CouponController::class);

    Route::resource('toppings', ToppingController::class);
    
    Route::resource('side_options', SideOptionController::class);

    Route::controller(UserAccountController::class)->group(function(){
        Route::get('/UserAccount/edit' , 'edit')->name('UserAccount.edit');
        Route::put('/UserAccount/update' , 'update')->name('UserAccount.update');
        Route::put('/UserAccount/update-password' , 'update_password')->name('UserAccount.update_password');
    });


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
