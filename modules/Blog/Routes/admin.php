<?php

use Illuminate\Support\Facades\Route;

Route::get('blog/posts', [
    'as' => 'admin.blog_posts.index',
    'uses' => 'BlogPostController@index',
    'middleware' => 'can:admin.blog_posts.index',
]);

Route::get('blog/posts/create', [
    'as' => 'admin.blog_posts.create',
    'uses' => 'BlogPostController@create',
    'middleware' => 'can:admin.blog_posts.create',
]);

Route::post('blog/posts', [
    'as' => 'admin.blog_posts.store',
    'uses' => 'BlogPostController@store',
    'middleware' => 'can:admin.blog_posts.create',
]);

Route::get('blog/posts/{id}/edit', [
    'as' => 'admin.blog_posts.edit',
    'uses' => 'BlogPostController@edit',
    'middleware' => 'can:admin.blog_posts.edit',
]);

Route::put('blog/posts/{id}', [
    'as' => 'admin.blog_posts.update',
    'uses' => 'BlogPostController@update',
    'middleware' => 'can:admin.blog_posts.edit',
]);

Route::delete('blog/posts/{ids}', [
    'as' => 'admin.blog_posts.destroy',
    'uses' => 'BlogPostController@destroy',
    'middleware' => 'can:admin.blog_posts.destroy',
]);

Route::get('blog/posts/index/table', [
    'as' => 'admin.blog_posts.table',
    'uses' => 'BlogPostController@table',
    'middleware' => 'can:admin.blog_posts.index',
]);

Route::get('blog/categories', [
    'as' => 'admin.blog_categories.index',
    'uses' => 'BlogCategoryController@index',
    'middleware' => 'can:admin.blog_categories.index',
]);

Route::get('blog/categories/create', [
    'as' => 'admin.blog_categories.create',
    'uses' => 'BlogCategoryController@create',
    'middleware' => 'can:admin.blog_categories.create',
]);

Route::post('blog/categories', [
    'as' => 'admin.blog_categories.store',
    'uses' => 'BlogCategoryController@store',
    'middleware' => 'can:admin.blog_categories.create',
]);

Route::get('blog/categories/{id}/edit', [
    'as' => 'admin.blog_categories.edit',
    'uses' => 'BlogCategoryController@edit',
    'middleware' => 'can:admin.blog_categories.edit',
]);

Route::put('blog/categories/{id}', [
    'as' => 'admin.blog_categories.update',
    'uses' => 'BlogCategoryController@update',
    'middleware' => 'can:admin.blog_categories.edit',
]);

Route::delete('blog/categories/{ids}', [
    'as' => 'admin.blog_categories.destroy',
    'uses' => 'BlogCategoryController@destroy',
    'middleware' => 'can:admin.blog_categories.destroy',
]);

Route::get('blog/categories/index/table', [
    'as' => 'admin.blog_categories.table',
    'uses' => 'BlogCategoryController@table',
    'middleware' => 'can:admin.blog_categories.index',
]);

Route::get('blog/tags', [
    'as' => 'admin.blog_tags.index',
    'uses' => 'BlogTagController@index',
    'middleware' => 'can:admin.blog_tags.index',
]);

Route::get('blog/tags/create', [
    'as' => 'admin.blog_tags.create',
    'uses' => 'BlogTagController@create',
    'middleware' => 'can:admin.blog_tags.create',
]);

Route::post('blog/tags', [
    'as' => 'admin.blog_tags.store',
    'uses' => 'BlogTagController@store',
    'middleware' => 'can:admin.blog_tags.create',
]);

Route::get('blog/tags/{id}/edit', [
    'as' => 'admin.blog_tags.edit',
    'uses' => 'BlogTagController@edit',
    'middleware' => 'can:admin.blog_tags.edit',
]);

Route::put('blog/tags/{id}', [
    'as' => 'admin.blog_tags.update',
    'uses' => 'BlogTagController@update',
    'middleware' => 'can:admin.blog_tags.edit',
]);

Route::delete('blog/tags/{ids}', [
    'as' => 'admin.blog_tags.destroy',
    'uses' => 'BlogTagController@destroy',
    'middleware' => 'can:admin.blog_tags.destroy',
]);

Route::get('blog/tags/index/table', [
    'as' => 'admin.blog_tags.table',
    'uses' => 'BlogTagController@table',
    'middleware' => 'can:admin.blog_tags.index',
]);
