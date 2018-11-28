<?php

use App\Functions;
use Illuminate\Http\Request;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['api.auth']], function () {
    Route::get('/profile', 'API\Users\ProfileApiController@get_user_profile_info');
    Route::post('/add_account', 'API\Users\ProfileApiController@add_bank_account');
    Route::get('/list_account', 'API\Users\ProfileApiController@get_bank_account');
    Route::get('/delete_account/{id}', 'API\Users\ProfileApiController@delete_bank_account');
});
Route::post('bank_id', function (Request $request){
    $bank = Functions::getBankAccountByUser($request->id);
return $bank;
});
//Route::post('/edit_account', 'API\Users\ProfileApiController@');
