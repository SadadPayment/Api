<?php

use Illuminate\Http\Request;
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/profile', 'API\Users\ProfileApiController@get_user_profile_info')->middleware('jwt.auth');
Route::post('/add_account', 'API\Users\ProfileApiController@add_bank_account')->middleware('jwt.auth');
Route::get('/list_account', 'API\Users\ProfileApiController@get_bank_account')->middleware('jwt.auth');
//Route::post('/edit_account', 'API\Users\ProfileApiController@');
