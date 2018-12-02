<?php

namespace App\Model\Payment;

use App\Functions;
//use App\Model\Account\BankAccount;
use App\Model\SendRequest;
use App\Model\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

/**
 * App\Model\Payment\Electricity
 *
 * @property int $id
 * @property int|null $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $meter
 * @property-read \App\Model\Payment\Payment|null $payment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\Electricity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\Electricity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\Electricity whereMeter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\Electricity wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\Electricity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Electricity extends Model
{
    //
    protected $fillable=['meter'];
    protected $table="electricites";
    const Payment = "payment";
    //


    public function payment(){
        return $this->belongsTo('App\Model\Payment\Payment' , 'payment_id');
    }

    public static function requestBuild($transaction_id , $ipin, $bank_id){
        $transaction = Transaction::where("id", $transaction_id)->first();
        $user = User::where("id",$transaction->user_id)->first();
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $electricity = Electricity::where("payment_id",$payment->id)->first();
        //dd($electricity);

        $tranCurrency = "SDG";


        $request = array();
        $request += ["applicationId" => "Sadad"];

        $transDateTime = $transaction->transDateTime;

        $request += ["tranDateTime" => $transDateTime];
        $uuid = $transaction->uuid;
        $request += ["UUID" => $uuid];
        $request += ["tranCurrency" => $tranCurrency];
        $request += ["tranAmount" => $payment->amount];
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $PAN = "";
        $mbr = "";
        $expDate = "";
        $authenticationType = "00";
        $bank = Functions::getBankAccountByUser($bank_id);
        $PAN = $bank->PAN;
        $mbr = $bank->mbr;
        $expDate = $bank->expDate;

        $payee_id = "0010020001";
        $request += ["payeeId" => $payee_id];
        $payment_info ="METER =" . $electricity->meter;
        $request += ["paymentInfo" => $payment_info];

        $request += ["userName" => $userName];
        $request += ["userPassword" => $userPassword];

        $request += ["entityType" => $entityType];
        $request += ["PAN" => $PAN];

        $request += ["mbr" => $mbr];
        $request += ["expDate" => $expDate];
        $request += ["IPIN" => $ipin];
        $request += ["authenticationType" => $authenticationType];
        $request += ["fromAccountType" => "00"];
        //dd($request);
        return $request;
    }
    public static function sendRequest($transaction_id , $ipin, $bank_id){
        $request = self::requestBuild($transaction_id , $ipin, $bank_id);

        $response = SendRequest::sendRequest($request , self::Payment);
        return $response;

    }


}
