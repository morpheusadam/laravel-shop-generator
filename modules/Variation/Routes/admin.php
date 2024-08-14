<?php

use Illuminate\Support\Facades\Route;

Route::get('variations', [
    'as' => 'admin.variations.index',
    'uses' => 'VariationController@index',
    'middleware' => 'can:admin.variations.index',
]);

Route::get('variations/create', [
    'as' => 'admin.variations.create',
    'uses' => 'VariationController@create',
    'middleware' => 'can:admin.variations.create',
]);

Route::post('variations', [
    'as' => 'admin.variations.store',
    'uses' => 'VariationController@store',
    'middleware' => 'can:admin.variations.create',
]);

Route::get('variations/{id}', [
    'as' => 'admin.variations.show',
    'uses' => 'VariationController@show',
    'middleware' => 'can:admin.variations.index',
]);

Route::get('variations/{id}/edit', [
    'as' => 'admin.variations.edit',
    'uses' => 'VariationController@edit',
    'middleware' => 'can:admin.variations.edit',
]);

Route::put('variations/{id}', [
    'as' => 'admin.variations.update',
    'uses' => 'VariationController@update',
    'middleware' => 'can:admin.variations.edit',
]);

Route::delete('variations/{ids}', [
    'as' => 'admin.variations.destroy',
    'uses' => 'VariationController@destroy',
    'middleware' => 'can:admin.variations.destroy',
]);

Route::get('variations/index/table', [
    'as' => 'admin.variations.table',
    'uses' => 'VariationController@table',
    'middleware' => 'can:admin.variations.index',
]);
