<?php

use Illuminate\Support\Facades\Route;

Route::get('cart', 'CartController@index')->name('cart.index');
Route::delete('cart/clear', 'CartController@clear')->name('cart.clear');

Route::post('cart/items', 'CartItemController@store')->name('cart.items.store');
Route::put('cart/items/{id}', 'CartItemController@update')->name('cart.items.update');
Route::delete('cart/items/{id}', 'CartItemController@destroy')->name('cart.items.destroy');

Route::post('cart/taxes', 'CartTaxController@store')->name('cart.taxes.store');

Route::post('cart/shipping-method', 'CartShippingMethodController@store')->name('cart.shipping_method.store');

Route::get('cart/cross-sell-products', 'CartCrossSellProductsController@index')->name('cart.cross_sell_products.index');
