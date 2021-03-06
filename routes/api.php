<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("register", "API\AuthController@registration")->middleware('cors');
Route::post("activate", "API\AuthController@activate");
//Route::post("login", "API\AuthController@authenticate");
Route::post("login", "API\AuthController@Login");
Route::post("requestreset", "API\AuthController@resetPassword");
Route::post("resetpassword", "API\AuthController@resetPasswordWithCode");
//Route::post('payment' , 'ApiController@payment')->middleware('jwt.auth');
//Route::post('payment_account' , 'ApiController@payment_account')->middleware('jwt.auth');
Route::group(['middleware' => ['api.auth']], function () {

    Route::post('topUp', 'API\TopUp@topUp');
    Route::post('balance_inquiry', 'API\BalanceInquiry@balance_inquiry');
    Route::post('cardTransfer', 'API\CardTransfer@card_transfer');
    Route::post('electricity', 'API\Electricity@electricity');
    Route::post('e15_payment', 'API\E15@e15_payment');
    Route::post('e15_inquiry', 'API\E15@e15_inquiry');
    Route::get('getByUsers', 'API\ElectHistoryApiController@getByUsers');
    Route::get('getAllTransaction', 'API\HistoryApi@getAllTransactionsByUser');
    Route::get('wallet', 'API\Wallet@balance_inquiry');
    Route::post('bashairs', 'API\BashairApiController@bashair');
    Route::post('purchase', 'API\Payment\PurchaseUserControllerApi@userPurchase');
});
URL::forceScheme('https');