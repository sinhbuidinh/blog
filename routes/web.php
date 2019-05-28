<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/customers', 'CustomersController@index')->name('customers');

Route::prefix('user')->namespace('User')->group(function(){
    Route::get('/', 'HomeController@index')->name('user.index');
    Route::get('/contact', 'HomeController@contact')->name('user.contact');
    Route::get('/about', 'HomeController@about')->name('user.about');
    Route::get('/category', 'HomeController@category')->name('user.category');
    Route::get('/blog', 'HomeController@blog')->name('user.blog');
});

Route::prefix('admin')->namespace('Admin')->group(function(){
});
