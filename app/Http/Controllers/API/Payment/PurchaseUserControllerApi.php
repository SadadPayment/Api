<?php

namespace App\Http\Controllers\API\Payment;

use App\Functions;
use App\Model\Payment\Payment;
use App\Model\Payment\Purchase\PurchaseUser;
use App\Model\PublicKey;
use App\Model\Response\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;
use Tymon\JWTAuth\Facades\JWTAuth;


class PurchaseUserControllerApi extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function userPurchas(Request $request)
    {
        if ($request->isJson()) {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();


            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/
            $transaction = new Transaction();
            $transaction->user()->associate($user);
            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/

            $transaction = new Transaction();
            $transaction->user()->associate($user);
            $transaction_type = TransactionType::where('name', "E15")->pluck('id')->first();
            $transaction->transactionType()->associate($transaction_type);
            $convert = Functions::getDateTime();
            $uuid = Uuid::generate()->string;
            $transaction->uuid = $uuid;
            $transaction->transDateTime = $convert;
            $transaction->status = "created";
            $transaction->save();

            /*
             * Payment Table Save
             * @Parameter amount
             * tran
             * */
            $payment = new Payment();
            $payment->transaction()->associate($transaction);
            $payment->amount = $request->tranAmount;
            $payment->save();

            /*
             * Save Purchase
             * @Parameter phone
             * @ invoiceNumber
             * */
            $Purchase = new PurchaseUser();
            $Purchase->payment()->associate($payment);
//            $Purchase->tranAmount = $request->tranAmount;
            $Purchase->PAN = $request->PAN;
            $Purchase->save();

            //Tran status
            $transaction->status = "Send Request";
            $transaction->save();

            //Get PublicKey get Value Per Request
            $publicKey = PublicKey::sendRequest();
            if ($publicKey == false) {
                $res = ["message" => "خطا - حاول لاحقا", 'error' => true];
                return response()->json($res, 200);
            }
            $ipin = Functions::encript($publicKey, $uuid, $request->IPIN);

            //$req = E15Model::requestBuild($transaction->id,$ipin,$type);
            $response = PurchaseUser::sendRequest($transaction->id, $request->PAN, $request->IPIN, $request->expDate, $user->id);
            if ($response == false) {
                $res = ["message" => "Some Error Found", 'error' => true];
                return response()->json($res, 200);
            }
//            dd($response);
            //اذا الرد = 0 معناه العملية تمت بنجاح
            // اكبر من 0 او غيره  خطأ من ebs
            if ($response->responseCode != 0) {
                //repons code in 29
                //Tran status
                $transaction->status = "Ebs Error";
                $transaction->save();
                $response_json = ["message" => "خطا- راجع البيانات المدخله", "ebs" => $response, 'error' => true];
                return response()->json($response_json, 200);
            }

            $basicResponse = Response::saveBasicResponse($transaction, $response);

            //Tran status
            $transaction->status = "Done";
            $transaction->save();
            $json = array();

            $responseData = [
                'date' => $transaction->created_at->format('d-m-Y H:i'),
                'id' => $transaction->id
            ];// get Time and id of Request
            $json += ['ebs' => $response];
            $json += [
                "error" => false,
                "message" => "تم بنجاح",
                "response" => $basicResponse, 'data' => $responseData];
            return response()->json($json, 200);
        } else {
            $response = ["message" => "Request Must Be Json", 'error' => true];
            return response()->json($response, 200);
        }
    }


}