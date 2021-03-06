<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
           'email'=>'required',
           'password'=>'required',
        ]);
        $credentials = $request->only(['email','password']);
        if (!$token = auth()->attempt($credentials)){
            return response()->json(['error'=>'Email or password not matched'],401);
        }
        return $this->respondWithToken($token);
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
