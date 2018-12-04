<?php

namespace App\Http\Controllers\API;

use App\Model\Account\BankAccount;
use App\Model\ResetPassword;
use App\Model\User;
use App\Model\UserValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
//use Validator;
use App\Functions;

class AuthController extends Controller
{
//
//    public function login(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'phone' => 'required|string|max:10',
//            'password' => 'required|min:6'
//        ]);
//        if ($validator->fails()) {
//            return response()->json($validator->errors());
//        }
//        $user = User::where("phone", $request->phone)->first();
//        if ($user == null) {
//            $response = ["error" => true, "message" => "wrong phone number"];
//            return response()->json($response, 200);
//        }
//        if ($user) {
//            $credentials = $request->only('phone', 'password');
//            try {
//                if (!$token = JWTAuth::fromUser($credentials)) {
//                    return response()->json(['error' => 'invalid_credentials'], 401);
//                }
//
//            } catch (JWTException $e) {
//                return response()->json(['error' => 'could_not_create_token'], 500);
//            }
////            return $this->respondWithToken($token, $credentials);
//            $response = ["error" => false, "token" => $token, 'userInfo' => $user, "message" => "OK"];
//            return response()->json($response, 200);
//        }
//        return response()->json('error', 200);
//
//}

//    public function authenticate(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//                'phone' => 'required',
//                'password' => 'required',
//            ]
//        );
//        if ($validator->fails()) {
//            return response()->json([
//                'error' => true,
//                'errors' => $validator->errors()->toArray()
//            ]);
//        }
//
//
//        $phone = $request->json()->get("phone");
//        $password = $request->json()->get("password");
//        try {
//            $user = User::where("phone", $phone)->first();
//            if ($user == null) {
//                $response = ["error" => true, "message" => "wrong phone number"];
//                return response()->json($response, 200);
//            }
//                if ($user->status == "1") {
//                    $credentials = $request->only('phone', 'password');
////                    if (!$token = JWTAuth::fromUser($credentials)) {
////                    return response()->json(['error' => 'invalid_credentials'], 401);
////                }
//                    $token = JWTAuth::fromUser($user);
//                    $response = ["error" => false, "token" => $token, 'userInfo' => $user, "message" => "OK"];
//                    return response()->json($response, 200);
//                } else {
//                    $response = ["error" => true, "message" => "You Have To Activate Your Account First"];
//                    return response()->json($response, 200);
//                }
////            }
//        } catch (JWTException $ex) {
//            $response = ["error" => true, "message" => "Something went wrong"];
//            return response()->json($response, 200);
//        }
//    }


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
                'fullName' => 'required|string',
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


            $user = $request->json();
            $fullName = $user->get("fullName");
            $phone = $user->get("phone");
            $password = $user->get("password");
            $PAN = $user->get("PAN");
            $IPIN = $user->get("IPIN");
            $expDate = $user->get("expDate");
            $mbr = "0";


            $user = new User();
            $user->password = Hash::make($password);
            $user->phone = $phone;
            $user->fullName = $fullName;
            $user->save();
            $code = rand(100000, 999999);
            $validate = new UserValidation();
            $validate->phone = $phone;
            $validate->code = $code;
            $validate->save();
            $expDate = Functions::convertExpDate($expDate);
            BankAccount::saveBankAccountByUser($PAN, $IPIN, $expDate, $mbr, $user);
            self::sendSMS($phone, $code);
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
            $user = User::where("phone", $phone)->first();
            $user->status = "1";
            $user->save();
            $token = JWTAuth::fromUser($user);
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
        $response = ["error" => false, "message" => "تم ارسال رمز التاكيد في رسالة"];
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
            "user"=>$credentials,
            'error'=> false
        ]);
    }
}
