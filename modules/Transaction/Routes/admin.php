<?php

use Illuminate\Support\Facades\Route;

Route::get('transactions', [
    'as' => 'admin.transactions.index',
    'uses' => 'TransactionController@index',
    'middleware' => 'can:admin.transactions.index',
]);

Route::get('transactions/index/table', [
    'as' => 'admin.transactions.table',
    'uses' => 'TransactionController@table',
    'middleware' => 'can:admin.transactions.index',
]);
