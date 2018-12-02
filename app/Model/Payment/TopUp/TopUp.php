<?php

namespace App\Model\Payment\TopUp;

use App\Functions;
use App\Model\Account\BankAccount;
use App\Model\Payment\Payment;
use App\Model\SendRequest;
use App\Model\Transaction;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Payment\TopUp\TopUp
 *
 * @property int $id
 * @property int $payment_id
 * @property int $biller_id
 * @property string $payee_id
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Payment\TopUp\TopUpBiller $biller
 * @property-read \App\Model\Payment\Payment $payment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\TopUp\TopUp whereBillerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\TopUp\TopUp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\TopUp\TopUp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\TopUp\TopUp wherePayeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\TopUp\TopUp wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\TopUp\TopUp wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment\TopUp\TopUp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TopUp extends Model
{
    //
    protected $fillable=[ 'payment_id' , 'biller_id' , 'payee_id' , 'phone' , 'amount'];
    public function payment(){
        return $this->belongsTo('App\Model\Payment\Payment' , 'payment_id');
    }
    public function biller(){
        return $this->belongsTo('App\Model\Payment\TopUp\TopUpBiller' , 'biller_id');
    }

    const Payment = "payment";

    public static function getTopUp($type_id, $biller_id)
    {
        return self::where('type_id', $type_id)->where('biller_id', $biller_id)->first();
    }
    public static function requestBuild($transaction_id,$ipin, $bank_id)
    {
        $transaction = Transaction::where("id", $transaction_id)->first();
        $user = User::where("id",$transaction->user_id)->first();
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $topUp = TopUp::where("payment_id",$payment->id)->first();


        //return ["id" => $payment->service];
        $tranCurrency = "SDG";
        $tranAmount = "";


        $request = array();
        $request += ["applicationId" => "Sadad"];
        //$tr = array();
        //$tr += ["tranDateTime" => $transaction->transDateTime];

        //return $tr;

        $transDateTime = $transaction->transDateTime;

        $request += ["tranDateTime" => $transDateTime];
        $uuid = $transaction->uuid;
        $request += ["UUID" => $uuid];
        $request += ["tranCurrency" => $tranCurrency];
        $request += ["tranAmount" => 3];
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";
        $bank = Functions::getBankAccountByUser($bank_id);
        $PAN = $bank->PAN;
        $mbr = $bank->mbr;
        $expDate = $bank->expDate;



        $request += ["userName" => $userName];
        $request += ["userPassword" => $userPassword];
        //$request += ["entityId" => $entityId];
        $request += ["entityType" => $entityType];
        $request += ["PAN" => $PAN];

        $paymentInfo = "MPHONE =" . $topUp->phone;
        $request += ["paymentInfo" => $paymentInfo];

        $request += ["payeeId" => $topUp->payee_id];
        $request += ["mbr" => $mbr];
        $request += ["expDate" => $expDate];
        $request += ["IPIN" => $ipin];
        //echo $IPIN . "<br>";
        $request += ["authenticationType" => $authenticationType];
        $request += ["fromAccountType" => "00"];
        //dd($request);
        return $request;
        //$request->tranDateTime = $transaction->transDateTime;
    }
    public static function sendRequest($transaction_id,$ipin, $bank_id){
        $request = self::requestBuild($transaction_id ,$ipin, $bank_id);

        $response = SendRequest::sendRequest($request , self::Payment);
        return $response;

    }



}
