<?php

namespace App\Http\Controllers\API\Users;

use App\Model\Account\BankAccount;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileApiController extends Controller
{
    public function get_user_profile_info()
    {
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        $profile = User::with(['accounts'])
            ->find($user->id);
        if ($profile) {
            return response()->json($profile);
        }
        return response()->json(['error' => true]);
    }

    public function add_bank_account(Request $request)
    {
        return $request;
//        try {
//            $token = JWTAuth::parseToken();
//            $user = $token->authenticate();
//            $save_account = new BankAccount();
//            $save_account->name = $request->name;
//            $save_account->PAN = $request->PAN;
//            $save_account->IPIN = $request->IPIN;
//            $save_account->expDate = $request->expDate;
//            $save_account->mbr = 0;
//            $save_account->user_id = $user->id;
//            $save_account->save();
//            if ($save_account) {
//                return response()->json(true);
//            }
//            return response()->json(false);
//        }
//        catch (\Exception $exception){
//            return response()->json($exception);
//        }
    }

    public function get_bank_account(){
        try {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $account = BankAccount::where('user_id', $user->id)->get();
            if ($account){
                return response()->json($account);
            }
            return response()->json('error');
        }
        catch (\Exception $exception){
            return response()->json($exception);
        }
    }

}
