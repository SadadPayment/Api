<?php

namespace App\Http\Controllers\API\Users;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
