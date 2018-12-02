<?php
/**
 * Created by PhpStorm.
 * User: ppain
 * Date: 02/12/18
 * Time: 05:50 م
 */


Route::post("register", "API\AuthController@registration")->middleware('cors');
Route::post("activate", "API\AuthController@activate");
//Route::post("login", "API\AuthController@authenticate");
Route::post("login", "API\AuthController@Login");
Route::post("requestreset", "API\AuthController@resetPassword");
Route::post("resetpassword", "API\AuthController@resetPasswordWithCode");