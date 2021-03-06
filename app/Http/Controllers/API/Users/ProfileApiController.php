<?php

namespace App\Http\Controllers\API\Users;

use App\Functions;
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
        try {
            $expDate = Functions::convertExpDate($request->expDate);
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            $save_account = new BankAccount($request->all());
            $save_account->expDate = $expDate;
            $save_account->mbr = 0;
            $save_account->user_id = $user->id;
            $save_account->save();
            if ($save_account) {
                return response()->json(true);
            }
            return response()->json(false);
        }
        catch (\Exception $exception){
            return response()->json($exception);
        }
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

    public function delete_bank_account($id)
    {
        try{
            $delet= BankAccount::destroy($id);
            if ($delet){
                    $token = JWTAuth::parseToken();
                    $user = $token->authenticate();
                    $account = BankAccount::where('user_id', $user->id)->get();
                    if ($account){
                        return response()->json($account);
                    }
            }
            return response()->json('error');

        }
        catch (\Exception $exception){
            return response()->json($exception);
        }
    }

}
