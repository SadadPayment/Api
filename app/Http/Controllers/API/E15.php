<?php

namespace App\Http\Controllers\API;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Model\Payment\Payment;
use App\Model\PublicKey;
use App\Model\Response\E15Response;
use App\Model\Response\PaymentResponse;
use App\Model\Response\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Webpatser\Uuid\Uuid;
use App\Model\Payment\E15 as E15Model;

class E15 extends Controller
{
    //public e15
    public function e15(Request $request, $type)
    {
        if ($request->isJson()) {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();

            $validator = Validator::make($request->all(), [
                    'phone' => 'required|numeric',
                    'IPIN' => 'required|numeric|digits_between:4,4',
                    'amount' => 'required|numeric',
                    'invoiceNo' => 'required|numeric',
                ]
            );
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
                //$user = JWTAuth::toUser($token);
                /******   Create Transaction Object  *********/
            $phone = $request->json()->get("phone");
            $amount = $request->json()->get("amount");
            $amount = number_format((float)$amount, 2, '.', '');

            $ipin = $request->json()->get("IPIN");
            $invoice = $request->json()->get("invoiceNo");

            $bank = Functions::getBankAccountByUser($user);
            if ($ipin !== $bank->IPIN) {
                $response = ["message" => "Wrong IPIN Code", "error" => true];
                return response()->json($response, 200);
            }
            //جدول حفظ البيانات المنقولة جواً
            /*
             * تخزين بينات العضو
             * نوع العملية مع التحقق من النوع
             * ربط بين جدوليا
             * Creat Uuid and get cur dateTime
             * */
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
             * @parme amount
             * tran
             * */
            $payment = new Payment();
            $payment->transaction()->associate($transaction);
            $payment->amount = $amount;
            $payment->save();

            /*
             * Save E15
             * @parm phone
             * @ invoiceNumber
             * */
            $e15 = new E15Model();
            $e15->payment()->associate($payment);
            $e15->phone = $phone;
            $e15->invoice_no = $invoice;
            $e15->save();

            //Tran status
            $transaction->status = "Send Request";
            $transaction->save();

            //Get PublicKey get Value Per Request
            $publickKey = PublicKey::sendRequest();
            if ($publickKey == false) {
                $res = ["message" => "Server Error", 'error' => true];
                return response()->json($res, 200);
            }
            $ipin = Functions::encript($publickKey, $uuid, $ipin);

            //$req = E15Model::requestBuild($transaction->id,$ipin,$type);
            $response = E15Model::sendRequest($transaction->id, $ipin, $type);
            if ($response == false) {
                $res = ["message" => "Some Error Found", 'error' => true];
                return response()->json($res, 200);
            }
//            dd($response);
            //اذا الرد = 0 معناه العملية تمت بنجاح
            // اكبر من 0 او غيره  خطأ من ebs
            if ($response->responseCode != 0) {
                //repons code in 29
                $response_json = ["message" => "Server error", "ebs" => $response, 'error' => true];
                return response()->json($response_json, 200);
            }

            $basicResonse = Response::saveBasicResponse($transaction, $response);

            $paymentResponse = PaymentResponse::savePaymentResponse($basicResonse, $payment, $response);
            //We swnd Type to verfiy whetther we have i_status and i_expiery
            self::saveE15Response($paymentResponse, $e15, $response, $type);


            $json = array();
            $bill_info = $response->billInfo;
            if ($type == 2) {
                $invoice_status = $bill_info->InvoiceStatus;
                $invoice_expiry = $bill_info->InvoiceExpiry;
                if ($invoice_status == 0) {
                    $status = "CANCELED";
                } else if ($invoice_status == 1) {
                    $status = "PENDING";
                } else {
                    $status = "PAID";
                }
                $json += ["status" => $status, "expiry" => $invoice_expiry];
            }

            $json += ["error" => false, "message" => "Done Successfully", "response" => $bill_info];
            return response()->json($json, 200);

        } else {
            $response = ["message" => "Request Must Be Json", 'error' => true];
            return response()->json($response, 200);
        }
    }

    //e15 payment
    public function e15_payment(Request $request)
    {
        return $this->e15($request, 6);
    }

    public function e15_inquery(Request $request)
    {
        return $this->e15($request, 2);
    }

    public static function saveE15Response($paymentResponse, $e15, $response, $type)
    {
        $e15_response = new E15Response();
        $e15_response->PaymentResponse()->associate($paymentResponse);
        $e15_response->E15()->associate($e15);
        $bill_info = $response->billInfo;
//        dd($bill_info);
//        $e15_response->fill($bill_info);
        $e15_response->UnitName = $bill_info->UnitName;
        $e15_response->ServiceName = $bill_info->ServiceName;
        $e15_response->TotalAmount = $bill_info->TotalAmount;
        $e15_response->ReferenceId = $bill_info->ReferenceId;
        $e15_response->PayerName = $bill_info->PayerName;
//        $e15_response->expiry = $bill_info->invoiceExpiryDate;
//        $e15_response->status = $bill_info->invoiceStatus;

        //	UnitName	ServiceName	TotalAmount	ReferenceId	PayerName
//        $e15_response->invoice_no = $bill_info->invoiceNo;
        if ($type == 2) {
            $e15_response->expiry = $bill_info->InvoiceExpiry;
            $e15_response->status = $bill_info->InvoiceStatus;
        }
        $e15_response->save();

    }
}
