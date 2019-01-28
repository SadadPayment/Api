<?php

namespace App\Http\Controllers\API\Payment;

use App\Functions;
use App\Model\Payment\Payment;
use App\Model\Payment\Purchase\PurchaseUser;
use App\Model\Payment\Purchase\PurchaseUserResponse as PurchaseResponse;
use App\Model\PublicKey;
use App\Model\Response\PaymentResponse;
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
     * @return array|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function userPurchase(Request $request)
    {
        if ($request->isJson()) {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $userCart = Functions::getBankAccountByUser($request->id);
            $serviceProviderId = $request->serviceProviderId;

            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/
            $transaction = new Transaction();
            $transaction->user()->associate($user);
            //$user = JWTAuth::toUser($token);
            /******   Create Transaction Object  *********/

            $transaction = new Transaction();
            $transaction->user()->associate($user);
            //مراجعة
            $transaction_type = TransactionType::where('name', "Purchase")->pluck('id')->first();
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
            if (!$userCart) {
                $r = ["message" => "خطأ لم تقم باختيار اي بطاقة", 'error' => true];
                return $r;
            }
            $Purchase = new PurchaseUser();
            $Purchase->payment()->associate($payment);
            $Purchase->PAN = $userCart->PAN;
            $Purchase->save();

            //Tran status
            $transaction->status = "Send Request";
            $transaction->save();

            //Get PublicKey get Value Per Request
            $publicKey = PublicKey::sendRequest();
            if ($publicKey == false) {
                $res = ["message" => "خطا - حاول لاحقا- 1", 'error' => true];
                return response()->json($res, 200);
            }
            $ipin = Functions::encript($publicKey, $uuid, $request->IPIN);

            $response = PurchaseUser::sendRequest($transaction->id, $ipin, $request->id, $serviceProviderId);
            if ($response == false) {
                $res = ["message" => "Some Error Found", 'error' => true];
                return response()->json($res, 200);
            }
            //اذا الرد = 0 معناه العملية تمت بنجاح
            // اكبر من 0 او غيره  خطأ من ebs
            if ($response->responseCode != 0) {
                //response code in 29
                //Tran status
                $transaction->status = "Ebs Error";
                $transaction->save();
                $response_json = ["message" => "خطا- راجع البيانات المدخله -2", "ebs" => $response, 'error' => true];
                return response()->json($response_json, 200);
            }

            $basicResponse = Response::saveBasicResponse($transaction, $response);
//            $paymentResponse = PaymentResponse::savePaymentResponse($basicResponse, $payment, $response);

//            $purchase_response = self::save_purchase_response($paymentResponse, $Purchase, $response);

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

//    public static function save_purchase_response($paymentResponse, $purchase, $response)
//    {
//        $purchase_response = new PurchaseResponse();
//        $purchase_response->PaymentResponse()->associate($paymentResponse);
//        $purchase_response->Purchase()->associate($purchase);
//        $purchase_response_save = (array)$response;
////        dd($purchase_response_save);
//        $purchase_response->fill($purchase_response_save);
////        $purchase_response->issuerTranFee = ;
////        $purchase_response->fromAccount = ;
////        $purchase_response->payment_response_id = ;
////        $purchase_response->purchase_user_id = ;
//        $purchase_response->save();
//        return $purchase_response;
//    }
}
