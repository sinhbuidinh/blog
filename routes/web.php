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

    Route::get('/google-get-token', function() {
        \Artisan::call('google:get-token');
        return 'get-token done';
    });
});

Route::namespace('User')->group(function(){
    Route::get('/', 'HomeController@index')->name('user.index');
    Route::get('/dinh-vi-buu-pham/{van_don_code?}', 'HomeController@locate')->name('user.locate');
    Route::get('/category/{type?}', 'HomeController@category')->name('user.category');
    Route::get('/gioi-thieu', 'HomeController@about')->name('user.about');
    Route::get('/lien-he', 'HomeController@contact')->name('user.contact');
    Route::get('/blog/{blog_id?}', 'HomeController@blog')->name('user.blog');

    Route::prefix('dich-vu')->group(function () {
        Route::get('/chuyen-phat-nhanh', 'HomeController@cpnService')->name('user.service.cpn');
        Route::get('/hoa-toc', 'HomeController@quickService')->name('user.service.quick');
        Route::get('/van-tai', 'HomeController@transportService')->name('user.service.transport');
    });

    Route::prefix('ho-tro')->group(function () {
        Route::get('/thoi-gian-toan-trinh', 'SupportController@fullTimeCourse')->name('user.support.full-time');
        Route::get('/bang-gia', 'SupportController@priceTbl')->name('user.support.price-tbl');
        Route::get('/phu-phi-nhien-lieu-va-ti-gia', 'SupportController@gasAndExchange')->name('user.support.gas-exchange');
        Route::get('/dich-vu-gtgt', 'SupportController@vat')->name('user.support.gtgt');
        Route::get('/bang-gia-van-tai', 'SupportController@transport')->name('user.support.transport');
    });
});


Route::get('/login', '\App\Http\Controllers\Auth\LoginController@index')->name('login');
Route::post('/login', '\App\Http\Controllers\Auth\LoginController@authenticate')->name('login');
Route::get('/register', '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', '\App\Http\Controllers\Auth\RegisterController@register')->name('register');
Route::post('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('get.logout');


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
    Route::prefix('transfered')->group(function () {
        Route::get('/', 'TransferedController@index')->name('transfereds');
        Route::get('/transfered/{id}', 'TransferedController@transfered')->name('transfer');
        Route::post('/transfered/{id}', 'TransferedController@completeTransfered')->name('complete_transfered');
        Route::get('/fail/{id}', 'TransferedController@fail')->name('fail');
        Route::post('/fail/{id}', 'TransferedController@failInfo')->name('fail_info');
    });
    Route::prefix('parcel')->group(function () {
        Route::get('/', 'ParcelController@index')->name('parcel');
        Route::get('/create', 'ParcelController@input')->name('parcel.input');
        Route::post('/create', 'ParcelController@create')->name('parcel.create');
        Route::get('/complete', 'ParcelController@complete')->name('create.parcel.complete');
        Route::get('/edit/{id}', 'ParcelController@edit')->name('parcel.edit');
        Route::get('/delete/{id}', 'ParcelController@delete')->name('parcel.delete');
        Route::post('/update/{id}', 'ParcelController@update')->name('parcel.update');
        Route::get('/export', 'ParcelController@export')->name('parcel.export');
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
        Route::get('/parcels/{id}', 'PackageController@parcels')->name('package.parcels');
        Route::get('/export/{id}', 'PackageController@export')->name('package.export');
    });

    Route::prefix('refund')->group(function () {
        Route::get('/', 'RefundController@index')->name('refund');
        Route::get('/create', 'RefundController@input')->name('refund.input');
        Route::post('/create', 'RefundController@create')->name('refund.create');
        Route::get('/complete', 'RefundController@complete')->name('create.refund.complete');
    });

    Route::prefix('forward')->group(function () {
        Route::get('/', 'ForwardController@index')->name('forward');
        Route::get('/create', 'ForwardController@input')->name('forward.input');
        Route::post('/create', 'ForwardController@create')->name('forward.create');
        Route::get('/complete', 'ForwardController@complete')->name('create.forward.complete');
    });
    Route::prefix('debt')->group(function () {
        Route::get('/', 'DebtController@index')->name('debt');
        Route::get('/export', 'DebtController@export')->name('debt.export');
    });
});
