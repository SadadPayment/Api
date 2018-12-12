<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Model\Payment\payee;
use App\Model\Payment\Payment;
use App\Model\Payment\TopUp\TopUp as TopUpModel;
use App\Model\Payment\TopUp\TopUpBiller;
use App\Model\PublicKey;
use App\Model\Response\PaymentResponse;
use App\Model\Response\Response;
use App\Model\Response\TopUpResponse;
use App\Model\TopUpType;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Webpatser\Uuid\Uuid;

class TopUp extends Controller
{
    //


    public function topUp(Request $request)
    {
        if ($request->isJson()) {
            $bank_id = $request->id;
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $validator = Validator::make($request->all(), [

                'phone' => 'required|numeric',
                'biller' => 'required|string',
                'amount' => 'required|numeric',
                'IPIN' => 'required|numeric|digits_between:4,4',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors()->toArray()
                ]);
            }
            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/
            $transaction = new Transaction();
            $transaction->user()->associate($user);
            $phone = $request->json()->get("phone");
            $biller = $request->json()->get("biller");
            $amount = $request->json()->get("amount");
//            $amount = number_format((float)$amount, 2, '.', '');
            $ipin = $request->json()->get("IPIN");
            $bank = Functions::getBankAccountByUser($bank_id);

            if ($ipin !== $bank->IPIN) {
                $response = ["error" => true, "message" => "Wrong IPIN Code"];
                return response()->json($response, 200);
            }
//            $account = array();
//            $account += ["PAN" => $bank->PAN];
//            $account += ["IPIN" => $bank->IPIN];
//            $account += ["expDate" => $bank->expDate];
//            $account += ["mbr" => $bank->mbr];

            $transction_type = TransactionType::where('name', "Top Up")->pluck('id')->first();
            $transaction->transactionType()->associate($transction_type);
            $convert = Functions::getDateTime();
            $uuid = Uuid::generate()->string;
            $transaction->uuid = $uuid;
            $transaction->transDateTime = $convert;
            $transaction->status = "created";
            $transaction->user()->associate($user);
            $transaction->save();
            $payment = new Payment();
            $payment->transaction()->associate($transaction);
            $payment->amount = $amount;
            $payment->save();

            $transaction->status = "Create Account";
            $transaction->save();

            $biller_id = self::getBillerId($biller);

            $topUp = new TopUpModel();
            $topUp->payment()->associate($payment);
            $topUp->biller()->associate($biller_id);
            $topUp->phone = $phone;
            $topUp->payee_id = self::getPayeeId($biller);
            $topUp->save();

            $transaction->status = "Save Top Up";
            $transaction->save();

            /*
             * Generate Public key Request From Ebs serve
             *
             * if pass move to nest
             * else Fill with server error Message
             * */
            $publicKey = PublicKey::sendRequest(); //
            if ($publicKey == false) {
                $res = ["error" => true, "message" => "Server Error"];
                return response()->json($res, 200);
            }
            $ipin = Functions::encript($publicKey, $uuid, $ipin);

            $response = TopUpModel::sendRequest($transaction->id, $ipin, $bank_id, $amount);
            if ($response == false) {
                $res = ["error" => true, "message" => "Some Error Found"];
                return response()->json($res, 200);
            }
            if ($response->responseCode != 0) {
                $transaction->status = "Server Error";
                $transaction->save();
                $res = ["error" => true, "message" => "خطا حاول لاحقا", 'code' => $response->responseCode];
                return response()->json($res, '200');
            } else {
                $basicResonse = Response::saveBasicResponse($transaction, $response);
                $paymentResponse = PaymentResponse::savePaymentResponse($basicResonse, $payment, $response);
                $saveTopUp = self::saveTopUp($paymentResponse, $topUp, $response);
                $transaction->status = "done";
                $transaction->save();
                $res = ["error" => false, "message" => "تم الشحن", 'full_response' => $response, 'data' => $saveTopUp];
                return response()->json($res, 200);


            }
        } else {
            $response = ["error" => true, "message" => "Request Must Be Json"];
            return response()->json($response, 200);
        }
    }


    public static function getBillerId($biller)
    {
        return TopUpBiller::where('name', $biller)->first();
    }

    public static function getTopUpTypeId($type)
    {
        return TopUpType::where('name', $type)->pluck('id')->first();
    }

    public static function getTopUp($type_id, $biller_id)
    {
        return TopUp::where('type_id', $type_id)->where('biller_id', $biller_id)->first();
    }

    public static function getPayeeId($biller)
    {
        $payee = payee::where("name", $biller)->first();
        return $payee->payee_id;
    }

    public static function saveTopUp($paymentResponse, $topUp, $response)
    {
        $top_up_response = new TopUpResponse();
        $top_up_response->PaymentResponse()->associate($paymentResponse);
        $top_up_response->TopUp()->associate($topUp);
        $top_up_response->status = "done";
        $top_up_response->save();
        return $top_up_response;
    }
}
