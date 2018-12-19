<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Model\Payment\Payment;
use App\Model\PublicKey;
use App\Model\Response\PaymentResponse;
use App\Model\Response\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use App\Model\Response\ElectricityResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Webpatser\Uuid\Uuid;
use App\Model\Payment\Electricity as ElectricityModel;

class Electricity extends Controller
{
    //
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function electricity(Request $request)
    {

        if ($request->isJson()) {
            $bank_id = $request->id;
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $validator = Validator::make($request->all(), [

                'meter' => 'required|numeric',
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
            $meter = $request->json()->get("meter");
            $amount = $request->json()->get("amount");
            $amount = number_format((float)$amount, 2, '.', '');
            $ipin = $request->json()->get("IPIN");

            $transction_type = TransactionType::where('name', "Electericity")->pluck('id')->first();
            $transaction->transactionType()->associate($transction_type);
            $convert = Functions::getDateTime();
            $uuid = Uuid::generate()->string;
            /*
             *  Create Transaction Object
             *
             */
            $transaction->uuid = $uuid;
            $transaction->transDateTime = $convert;
            $transaction->status = "created";
            $transaction->save();
            /*
             *   Create Payment Object
             */
            $payment = new Payment();
            $payment->transaction()->associate($transaction);
            $payment->amount = $amount;
            $payment->save();

            $transaction->status = "انشاء";
            $transaction->save();


            $electricity = new ElectricityModel();
            $electricity->payment()->associate($payment);
            $electricity->meter = $meter;
            $electricity->save();

            $transaction->status = "حفظ الكهرباء";
            $transaction->save();


            $publicKey = PublicKey::sendRequest();
            //dd($ipin);
            if ($publicKey == false) {
                $res = ["error" => true, "message" => "Server Error"];
                return response()->json($res, 200);
            }
            $ipin = Functions::encript($publicKey, $uuid, $ipin);


            $response = ElectricityModel::sendRequest($transaction->id, $ipin, $bank_id);
            if ($response == false) {
                $res = ["error" => true, "message" => "Some Error Found"];
                return response()->json($res, 200);
            }

            if ($response->responseCode != 0) {
                $transaction->status = "Server Error";
                $transaction->save();
                $res = ["error" => true, "full_response " => $response, 'errorCode'=> $response->responseCode];

                return response()->json($res, '200');
            } else {
                $basicResonse = Response::saveBasicResponse($transaction, $response);

                $paymentResponse = PaymentResponse::savePaymentResponse($basicResonse, $payment, $response);
                $electricityResponse = self::saveElectricityResponse($paymentResponse, $electricity, $response);//Tester Methods
                $transaction->status = "done";
                $transaction->save();
                $responseData = [
                    'date' => $transaction->created_at->format('d-m-Y H:i'),
                    'id' => $transaction->id
                ];// get Time and id of Request
                $res = array();
                $info = array();
                $info += ["meterFees" => $response->billInfo->meterFees];
                $info += ["netAmount" => $response->billInfo->netAmount];
                $info += ["unitsInKWh" => $response->billInfo->unitsInKWh];
                $info += ["waterFees" => $response->billInfo->waterFees];
                $info += ["token" => $response->billInfo->token];
                $info += ["customerName" => $response->billInfo->customerName];
                $info += ["operatorMessage" => $response->billInfo->opertorMessage];
                $info += ["electricityResponse" => $electricityResponse];
                $res += ["date" => $responseData];
                $res += ["error" => false];
                $res += ["message" => "تمت بنجاح"];
                $res += ["info" => $info, 'full_response' => $response];

                return response()->json($res, '200');
            }


        } else {
            $response = array();
            $response += ["error" => true];
            $response += ["message" => "Request Must Be Json"];
            return response()->json($response, 200);
        }
    }

    public static function saveElectricityResponse($paymentResponse, $electricity, $response)
    {
        $electricity_response = new ElectricityResponse();
        $electricity_response->PaymentResponse()->associate($paymentResponse);
        $electricity_response->Electricity()->associate($electricity);
        $bill_info = (array)$response->billInfo;

        $electricity_response->fill($bill_info);
        $electricity_response->operatorMessage = $response->billInfo->opertorMessage;
        $electricity_response->save();
        return $electricity_response;
    }
}
