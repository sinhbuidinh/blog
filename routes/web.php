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

Route::get('/home', 'CustomersController@index')->name('home');
Route::get('/customers', 'CustomersController@index')->name('customers');

Route::prefix('user')->namespace('User')->group(function(){
    Route::get('/', 'HomeController@index')->name('user.index');
    Route::get('/contact', 'HomeController@contact')->name('user.contact');
    Route::get('/about', 'HomeController@about')->name('user.about');
    Route::get('/category/{type?}', 'HomeController@category')->name('user.category');
    Route::get('/blog/{blog_id?}', 'HomeController@blog')->name('user.blog');
});


Route::get('/login', '\App\Http\Controllers\Auth\LoginController@index')->name('login');
Route::post('/login', '\App\Http\Controllers\Auth\LoginController@authenticate')->name('login');
Route::get('/register', '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', '\App\Http\Controllers\Auth\RegisterController@register')->name('register');
Route::post('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function(){
    Route::get('/', 'DashboardController@index');
    Route::prefix('dashboard')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
    });
    Route::prefix('parcel')->group(function () {
        Route::get('/', 'ParcelController@index')->name('parcel');
        Route::get('/create', 'ParcelController@input')->name('parcel.input');
        Route::post('/create', 'ParcelController@create')->name('parcel.create');
    });
});
