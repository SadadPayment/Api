<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Model\Payment\Bashair;
use App\Model\Payment\Payment;
use App\Model\PublicKey;
use App\Model\Response\BashairResponse;
use App\Model\Response\PaymentResponse;
use App\Model\Response\Response;
use App\Model\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Webpatser\Uuid\Uuid;

class BashairApiController extends Controller
{

    public static function saveBashiarResponse($paymentResponse, $bashair, $response)
    {
        $bashair_response = new BashairResponse();
        $bashair_response->PaymentResponse()->associate($paymentResponse);
        $bashair_response->bashair()->associate($bashair);
        $bill_info = $response->billInfo;
        $bashair_response->fill($bill_info);
        $bashair_response->save();
    }

    public function bashair(Request $request)
    {
        if (!$request->isJson()) {
            $response = ["message" => "Request Must Be Json", 'error' => true];
            return response()->json($response, 200);
        }
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();


        //$user = JWTAuth::toUser($token);
        /******   Create Transaction Object  *********/
        $transaction = new Transaction();
        $transaction->user()->associate($user);
        $transaction->transDateTime = Functions::getDateTime();
        $uuid = Uuid::generate()->string;
        $transaction->uuid = $uuid;
        $transaction->status = "created";
        $transaction->save();
        //Check Ipin
        $ipin = $request->json()->get("IPIN");
        $amount = $request->json()->get("amount");
        $bank = Functions::getBankAccountByUser($user);
        if ($ipin !== $bank->IPIN) {
            $response = ["message" => "Wrong IPIN Code", "error" => true];
            return response()->json($response, 200);
        }
        //Save Amount in Payment Tabel From Transaction Table
        $payment = new Payment();
        $payment->transaction()->associate($transaction);
        $payment->amount = $amount;
        $payment->save();

        //Save Bashair Payment Request
        $bashair = new Bashair();
        $bashair->payment()->associate($payment);
        $bashair->fill($request->all());
        $bashair->save();

        $publicKey= PublicKey::sendRequest();
        if ($publicKey == false) {
            $res = ["message" => "Server Error", 'error' => true];
            return response()->json($res, 200);
        }
        $ipin = Functions::encript($publicKey, $uuid, $ipin);

        $response = $bashair::sendRequest($bashair,$ipin);
        if ($response == false) {
            $res = ["message" => "Some Error Found", 'error' => true];
            return response()->json($res, 200);
        }
        if ($response->responseCode != 0) {
            //repons code in 29
            $response_json = ["message" => "Server error", "ebs" => $response, 'error' => true];
            return response()->json($response_json, 200);
        }
        $basicResonse = Response::saveBasicResponse($transaction, $response);

        $paymentResponse = PaymentResponse::savePaymentResponse($basicResonse, $payment, $response);

        self::saveBashiarResponse($paymentResponse, $bashair, $response);

        $response = [
          "error" => false,
          "message" => "Done",
          "data" => $response->billInfo
        ];
        return response()->json($response,200);

    }

}
