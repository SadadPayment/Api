<?php

namespace App\Http\Controllers\API\Purchase;

use App\Model\PublicKey;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Payment\Purchase\PurchaseUser as PurchaseModel;
use App\Model\Payment\Payment as PaymentModel;
use Validator;
use Webpatser\Uuid\Uuid;
use Tymon\JWTAuth\Facades\JWTAuth;

class PurchaseUserApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function store(Request $request)
    {
        //Check if Request is Json or not
        //if is Pass , not return error
        if ($request->isJson()) { //Start of Json Check if statement
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $validator = Validator::make($request->all(), [
                'PAN' => 'required|numeric|digits_between:12,19',
                'expDate' => 'required',
                'tranAmount' => 'required|numeric',
                'PIN' => 'required|numeric|digits_between:4,4',
            ]);
            if ($validator->fails()) {//Start of Validator Check if statement
                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors()->toArray()
                ]);
            }//End of Validator Check if statement

            //value from Request;
            $PAN = $request->PAN;
            $MerchantID = $user->id;
            $PIN = $request->PIN;
            $expDate = $request->expDate;
            /******   Create Transaction Object  *********/
            $transaction = new Transaction();
            $transaction->user()->associate($user);

            $transction_type = TransactionType::where('name', "Purchase")->pluck('id')->first();
            $transaction->transactionType()->associate($transction_type);
            $uuid = Uuid::generate()->string;
            $transaction->uuid = $uuid;
            $transaction->transDateTime = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $transaction->status = "created";
            $transaction->user()->associate($user);
            $transaction->save();//end Create First Transaction Status

            $payment = new PaymentModel(); //Create Payment Object From Payment Model
            $payment->transaction()->associate($transaction);// save LastTrans id
            $payment->amount = $request->tranAmount; //Trans Amount
            $payment->save();

            $transaction->status = "Create Account"; // update Transaction Status
            $transaction->save();

            $purchase = new PurchaseModel();// Create purchase Object From Purchase Model
            $purchase->PAN = $request->PAN; //Save Pan number
            $purchase->payment()->associate($payment); //Save Payment id from Last Payment
            $purchase->save();//end of Purchase Methods

            $transaction->status = "Save Purchase"; // update Transaction to Save purchase values
            $transaction->save();//end

            /*
         * Generate Public key Request From Ebs serve
         *
         * if pass move to nest
         * else Fill with server error Message
         * */
            $publicKey = PublicKey::sendRequest();
            if ($publicKey == false) {
                $res = ["error" => true, "message" => "Server Error"];
                return response()->json($res, 200);
            }

            //send Request to Model to resend to Ebs Server
            $response = PurchaseModel::sendRequest($transaction->id, $PAN, $PIN, $expDate, $MerchantID);
            if ($response == false) {
                $res = ["message" => "Some Error Found", 'error' => true];
                return response()->json($res, 200);
            }
            return response()->json($response);
        }//End of Json Check if statement
    } // End of Store Function


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
