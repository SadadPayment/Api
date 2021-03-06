<?php

namespace App\Http\Controllers\API;

use App\Model\Response\Response;
use App\Model\Transaction;
use App\Model\TransactionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class HistoryApi extends Controller
{
    //
    public function getAllTransactionsByUser(){
        $response = array();
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        $tran = Transaction::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->take(25)
            ->get();
        foreach ($tran as $transaction ){
            $transction_type = TransactionType::where('id', $transaction["transaction_type"])->pluck('name')->first();
            $res = Response::where("transaction_id" , $transaction["id"])->first();
            $response_one =["Response" => $res, "type" => $transction_type];
            $response[]=$response_one;
        }
        return response()->json(['data'=>$response]);
    }
}
