<?php

namespace App\Model;

use App\Functions;
use App\Model\Account\BankAccount;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\CardTransfer
 *
 * @property int $id
 * @property int $transfer_id
 * @property string $toCard
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Transfer $transfer
 * @method static \Illuminate\Database\Eloquent\Builder|CardTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardTransfer whereToCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardTransfer whereTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CardTransfer extends Model
{
    //
    const CardTransfer = "doCardTransfer";
    public function transfer(){
        return $this->belongsTo('App\Model\Transfer');
    }
    public static function requestBuild($transaction_id , $ipin, $bank_id){
        $request = array();
        $transaction = Transaction::where("id", $transaction_id)->first();
        $user = User::where("id",$transaction->user_id)->first();
        $transfer = Transfer::where("transaction_id", $transaction_id)->first();
        $card_transfer = CardTransfer::where("transfer_id",$transfer->id)->first();

        $uuid = $transaction->uuid;

        $tranAmount = $transfer->amount;
        $tranCurrency = "SDG";
        $toCard = $card_transfer->toCard;
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";
        $bank = Functions::getBankAccountByUser($bank_id);
        $PAN = $bank->PAN;
        $mbr = $bank->mbr;
        $expDate = $bank->expDate;
        //}
        $request += ["applicationId" => "Sadad"];
        $request += ["tranDateTime" => $transaction->transDateTime];
        $request += ["UUID" => $uuid];
        $request += ["userName" => $userName];
        $request += ["userPassword" => $userPassword];
        $request += ["entityId" => $entityId];
        $request += ["entityType" => $entityType];
        $request += ["tranCurrency" => $tranCurrency];
        $request += ["tranAmount" => $tranAmount];
        $request += ["toCard" => $toCard];
        $request += ["PAN" => $PAN];

        $request += ["mbr" => $mbr];
        $request += ["expDate" => $expDate];
        $request += ["IPIN" => $ipin];

        $request += ["fromAccountType" => "00"];
        $request += ["toAccountType" => "00"];
        $request += ["authenticationType" => $authenticationType];
        return $request;
    }
    public static function sendRequest($transaction_id, $ipin, $bank_id){
        $request = self::requestBuild($transaction_id, $ipin, $bank_id);

        $response = SendRequest::sendRequest($request , self::CardTransfer);
        return $response;

    }
}
