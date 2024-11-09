<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Token;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AuthenticationController extends Controller
{
    public function login(Request $request) {
        $email = $request->email;
        $password = $request->password;

        $request->validate([
            "email" => [ "required", "email" ],
            "password" => [ "required" ]
        ]);

        if(Auth::attempt([ 'email' => $email, "password" => $password ])) {
            $user = Auth::user();
            $token = $user->createToken('login')->plainTextToken;
            return response()->json([ "token" => $token, "status" => 200 ]);
        } else {
            return response()->json( [ "status" => 401, "message" => "Wrong Credentials" ] );
        }
    }
    public function logout(Request $request) {
        $token = $request->bearerToken();
        $is_deleted = PersonalAccessToken::findToken($token)->delete();
        if($is_deleted) $request->header("Authentication", "");
        return $is_deleted;
    }
}
