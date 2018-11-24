<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class API
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->guard('api')->user()) {
            return response()->json(['errorEn' => 'You must be user to do this',
                'errorAr' => 'يجب ان تكون عضوء او مسجل الدخول حتي تم هذا الأجراء']);
        }
        return $next($request);

//        if ($request->has('token')) {
//            try {
//                $jwt = new JWTAuth();
//                $this->auth = $jwt->parseToken()->authenticate();
//                return $next($request);
//            } catch (JWTException $e) {
//                $response = array();
//                $response += ["error" => true];
//                $response += ["message" => "Authentication Error"];
//                return response()->json($response,"200");
//            }
//        }
    }
}
