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
Route::prefix('artisan')->group(function () {
    Route::get('/key-generate', function() {
        \Artisan::call('key:generate');
        \Artisan::call('config:cache');
        return "key-generate done";
    });

    Route::get('/clear-cache', function() {
        \Artisan::call('config:cache');
        return 'clear done';
    });

    Route::get('/migrate', function() {
        \Artisan::call('migrate');
        return 'migrate done';
    });
});

Route::namespace('User')->group(function(){
    Route::get('/', 'HomeController@index')->name('user.index');
    Route::get('/dinh-vi-buu-pham/{van_don_code?}', 'HomeController@locate')->name('user.locate');
    Route::get('/category/{type?}', 'HomeController@category')->name('user.category');
    Route::get('/about', 'HomeController@about')->name('user.about');
    Route::get('/contact', 'HomeController@contact')->name('user.contact');
    Route::get('/blog/{blog_id?}', 'HomeController@blog')->name('user.blog');
});


Route::get('/login', '\App\Http\Controllers\Auth\LoginController@index')->name('login');
Route::post('/login', '\App\Http\Controllers\Auth\LoginController@authenticate')->name('login');
Route::get('/register', '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', '\App\Http\Controllers\Auth\RegisterController@register')->name('register');
Route::post('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');


Route::post('/ajax/get_price', '\App\Http\Controllers\Admin\ParcelController@ajaxCalculatePrice')->name('ajax.calculate.price');
Route::post('/ajax/get_districts/{province}', '\App\Http\Controllers\Admin\ParcelController@ajaxGetDistricts')->name('district.by.province');
Route::post('/ajax/get_wards/{district}', '\App\Http\Controllers\Admin\ParcelController@ajaxGetWards')->name('ward.by.district');

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
        Route::get('/complete', 'ParcelController@complete')->name('create.parcel.complete');
        Route::get('/edit/{id}', 'ParcelController@edit')->name('parcel.edit');
        Route::get('/delete/{id}', 'ParcelController@delete')->name('parcel.delete');
        Route::post('/update/{id}', 'ParcelController@update')->name('parcel.update');
    });
    Route::prefix('guest')->group(function () {
        Route::get('/', 'GuestController@index')->name('guest');
        Route::get('/create', 'GuestController@input')->name('guest.input');
        Route::post('/create', 'GuestController@create')->name('guest.create');
        Route::post('/update/{id}', 'GuestController@update')->name('guest.update');
        Route::get('/complete', 'GuestController@complete')->name('create.guest.complete');
        Route::get('/edit/{id}', 'GuestController@edit')->name('guest.edit');
        Route::get('/delete/{id}', 'GuestController@delete')->name('guest.delete');
    });
    Route::prefix('package')->group(function () {
        Route::get('/', 'PackageController@index')->name('package');
        Route::get('/create', 'PackageController@input')->name('package.input');
        Route::post('/create', 'PackageController@create')->name('package.create');
        Route::get('/complete', 'PackageController@complete')->name('create.package.complete');
        Route::get('/delete/{id}', 'PackageController@delete')->name('package.delete');
        Route::get('/transfer/{id}', 'PackageController@transfer')->name('package.transfer');
    });
});
