<?php

namespace App\Http\Controllers\API\Users;


use Agent;
use App\Model\Account\BankAccount;
use App\Model\ResetPassword;

//use App\Model\User;
//use App\Model\UserValidation;
use App\Model\UserValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
//use Validator;
use App\Functions;


class AuthAgents extends Controller
{
    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:10',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('phone', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return $this->respondWithToken($token, $credentials);
    }

    public function registration(Request $request)
    {
        if ($request->isJson()) {

            $validator = Validator::make($request->all(), [
                'phone' => 'required|unique:users|numeric',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users|string',
                'password' => 'required|string',
                'PAN' => 'required|numeric|digits_between:16,19|unique:bank_accounts',
                'IPIN' => 'required|numeric|digits_between:4,4',
                'expDate' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors()->toArray()
                ]);
            }


            $agent = new Agent($request->all());
            $agent->save();
            $code = rand(100000, 999999);
            $validate = new UserValidation();
            $validate->phone = $request->phone;
            $validate->code = $code;
            $validate->save();
            $expDate = Functions::convertExpDate($request->expDate);
            BankAccount::saveBankAccountByUser($request->PAN, $request->IPIN, $expDate, '0', $agent);
            self::sendSMS($request->phone, $code);
            $response = ["error" => false,
                "message" => "activate Your Account With the code that send to You in SMS",
                "messageAr" => "تم ارسال رمز التفعيل اليك"];

            return response()->json($response, 200);
        } else {
            $response = ["error" => true, "message" => "Request Must be json"];
            return response()->json($response, 200);
        }
    }

    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'phone' => 'required|numeric',
                'code' => 'required|numeric',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'errors' => $validator->errors()->toArray()
            ]);
        }


        $phone = $request->json()->get("phone");
        $code = $request->json()->get("code");


        $validate = UserValidation::where("phone", $phone)->where("code", $code)->get();
        if ($validate->isNotEmpty()) {
            $agent = Agent::where("phone", $phone)->first();
            $agent->status = "1";
            $agent->save();
            $token = JWTAuth::fromUser($agent);
            $response = ["error" => false, "message" => "Done", "token" => $token];
            return response()->json($response, 200);
        }
        $response = ["error" => true, "message" => "Error"];
        return response()->json($response, 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'phone' => 'requierd|numeric',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'errors' => $validator->errors()->toArray()
            ]);
        }
        $phone = $request->json()->get("phone");
        $code = rand(100000, 999999);
        $validate = new ResetPassword();
        $validate->phone = $phone;
        $validate->code = $code;
        $validate->save();
        self::sendSMS($phone, $code);
        $response = ["error" => false, "message" => "Code Have Been Sended to Your Phone"];
        return response()->json($response, 200);
    }

    public function resetPasswordWithCode(Request $request)
    {

        $validator = Validator::make($request->all(), [
                'phone' => 'requierd|numeric',
                'code' => 'requierd|numeric',
                'password' => 'requierd|string',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => false,
                'errors' => $validator->errors()->toArray()
            ]);
        }

        $phone = $request->json()->get("phone");
        $code = $request->json()->get("code");
        $password = $request->json()->get("password");

        $validate = ResetPassword::where("phone", $phone)->where("code", $code)->get();
        if ($validate->isNotEmpty()) {
            $user = User::where("phone", $phone)->first();
            $user->password = Hash::make($password);
            $user->save();
            $response = ["error" => false, "message" => "Password Have been Reset"];
            return response()->json($response, 200);
        }
        $response = ["error" => true, "message" => "Error"];
        return response()->json($response, 200);
    }

    public static function sendSMS($phone, $code)
    {
        $service_url = 'http://sms.iprosolution-sd.com/app/gateway/gateway.php';
        $curl = curl_init($service_url);
        $curl_post_data = array(
            "sendmessage" => 1,
            "username" => 'Sadad',
            "password" => 'Sadad@123',
            "text" => ' رمز التحقق هو  ' . $code,
            "numbers" => $phone,
            "sender" => 'Properties',
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($curl);
        curl_close($curl);
    }

    protected function respondWithToken($token, $credentials)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3000,
            "user" => $credentials,
            'error' => false
        ]);
    }
}
