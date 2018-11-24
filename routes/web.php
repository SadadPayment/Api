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
//use App\Http\Controllers\Auth;

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/home', 'Web\HomeController@index')->name('home');

Route::get('/logout', 'Auth\LoginController@logout');


Route::prefix('admin')->group(function () {


    Route::resource('merchants', 'Web\Admin\MerchantController');
    Route::resource('services', 'Web\Admin\ServicesController');
    Route::resource('users_management', 'Web\Admin\UsersManagementController');
    Route::resource('agent_management', 'Web\Admin\AgentsController');
//    Route::resource('merchants', 'Web\MerchantController');
//
//    Route::get('/test', 'Web\MerchantController@test');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
