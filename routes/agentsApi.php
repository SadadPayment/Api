<?php
/**
 * Created by PhpStorm.
 * User: ppain
 * Date: 02/12/18
 * Time: 05:50 م
 */


Route::post("register", "API\Users\AuthAgents@registration");
Route::post("activate", "API\Users\AuthAgents@activate");
//Route::post("login", "API\AuthController@authenticate");
Route::post("login", "API\Users\AuthAgents@Login");
Route::post("requestreset", "API\Users\AuthAgents@resetPassword");
Route::post("resetpassword", "API\Users\AuthAgents@resetPasswordWithCode");

Route::post('purchase', 'API\Merchant\PurchaseApiController@store');