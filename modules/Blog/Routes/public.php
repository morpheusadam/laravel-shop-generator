<?php

use Illuminate\Support\Facades\Route;

Route::get('blog/posts', 'BlogPostController@index')->name('blog_posts.index');
Route::get('blog/posts/{slug}', 'BlogPostController@show')->name('blog_posts.show');
Route::get('blog/search', 'BlogPostController@search')->name('blog.search');

Route::get('blog/categories/{category}/posts', 'BlogCategoryPostController@index')->name('blog_category.blog_posts.index');
Route::get('blog/tags/{tag}/posts', 'BlogTagPostController@index')->name('blog_tag.blog_posts.index');
