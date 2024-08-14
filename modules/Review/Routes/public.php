<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('products/{productId}/reviews', 'ProductReviewController@index')->name('products.reviews.index');
Route::post('products/{productId}/reviews', 'ProductReviewController@store')
    ->name('products.reviews.store')
    ->middleware(ProtectAgainstSpam::class);

Route::get('reviews/products', 'ReviewProductController@index')
    ->name('reviews.products.index')
    ->middleware('auth');
