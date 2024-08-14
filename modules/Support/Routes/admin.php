<?php

use Illuminate\Support\Facades\Route;


Route::get('sitemaps', [
    'as' => 'admin.sitemaps.create',
    'uses' => 'SitemapController@create',
]);


Route::post('sitemaps', [
    'as' => 'admin.sitemaps.store',
    'uses' => 'SitemapController@store',
]);
