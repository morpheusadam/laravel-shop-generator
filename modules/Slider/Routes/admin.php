<?php

use Illuminate\Support\Facades\Route;

Route::get('sliders', [
    'as' => 'admin.sliders.index',
    'uses' => 'SliderController@index',
    'middleware' => 'can:admin.sliders.index',
]);

Route::get('sliders/index/table', [
    'as' => 'admin.sliders.table',
    'uses' => 'SliderController@table',
    'middleware' => 'can:admin.sliders.index',
]);

Route::get('sliders/create', [
    'as' => 'admin.sliders.create',
    'uses' => 'SliderController@create',
    'middleware' => 'can:admin.sliders.create',
]);

Route::post('sliders', [
    'as' => 'admin.sliders.store',
    'uses' => 'SliderController@store',
    'middleware' => 'can:admin.sliders.create',
]);

Route::get('sliders/{id}/edit', [
    'as' => 'admin.sliders.edit',
    'uses' => 'SliderController@edit',
    'middleware' => 'can:admin.sliders.edit',
]);

Route::put('sliders/{id}', [
    'as' => 'admin.sliders.update',
    'uses' => 'SliderController@update',
    'middleware' => 'can:admin.sliders.edit',
]);

Route::delete('sliders/{ids?}', [
    'as' => 'admin.sliders.destroy',
    'uses' => 'SliderController@destroy',
    'middleware' => 'can:admin.sliders.destroy',
]);
