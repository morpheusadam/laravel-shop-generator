<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('contact', 'ContactController@create')->name('contact.create');
Route::post('contact', 'ContactController@store')
    ->name('contact.store')
    ->middleware(ProtectAgainstSpam::class);
