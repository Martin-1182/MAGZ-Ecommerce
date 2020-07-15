<?php

use TCG\Voyager\Facades\Voyager;
use Gloudemans\Shoppingcart\Facades\Cart;

Route::get('/', 'LandingPageController@index')->name('landing-page');

Route::get('/shop', 'ShopController@index')->name('shop.index');

Route::get('/shop/{product}', 'ShopController@show')->name('shop.show');

Route::get('/cart', 'CartController@index')->name('cart.index');

Route::post('/cart', 'CartController@store')->name('cart.store');

Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');

Route::post('/cart/switchToSaveForLater/{product}', 'CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}', 'SaveForLaterController@destroy')->name('saveForLater.destroy');

Route::post('/saveForLater/switchToCart/{product}', 'SaveForLaterController@switchToCart')
    ->name('saveForLater.switchToCart');

Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');

Route::get('empty', function () {
    Cart::instance('saveForLater')->destroy();
});

Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');

Route::get('/thankyou', 'ConfirmationController@index')->name('confirmation.index');

Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');

Route::post('/coupon', 'CouponsController@store')->name('coupon.store');

Route::delete('/coupon', 'CouponsController@destroy')->name('coupon.destroy');


Route::view('/product', 'product');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/guestCheckout', 'CheckoutController@index')->name('guestCheckout.index');

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', 'UsersController@edit')->name('users.edit');
    Route::patch('/my-profile', 'UsersController@update')->name('users.update');

    Route::get('/my-orders', 'OrdersController@index')->name('orders.index');
    Route::get('/my-orders/{order}', 'OrdersController@show')->name('orders.show');
});

Route::get('/mailable', function () {
    $order = App\Order::find(1);
    return new App\Mail\OrderPlaced($order);
});

Route::get('/search', 'ShopController@search')->name('search');

Route::get('/search-algolia', 'ShopController@searchAlgolia')->name('search-algolia');

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', 'UsersController@edit')->name('users.edit');
    Route::patch('/my-profile', 'UsersController@update')->name('users.update');

    Route::get('/my-orders', 'OrdersController@index')->name('orders.index');
    Route::get('/my-orders/{order}', 'OrdersController@show')->name('orders.show');
});