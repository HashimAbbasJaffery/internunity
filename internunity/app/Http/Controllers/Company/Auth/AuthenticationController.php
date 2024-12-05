<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationController extends Controller
{
    public function login(Request $request) {
        $email = $request->email;
        $password = $request->password;

        $request->validate([
            "email" => [ "required", "email" ],
            "password" => [ "required" ]
        ]);

        $companies = Company::where("email", $email)->first();
        if($companies && Hash::check($password, $companies->password)) {
            $token = $companies->createToken('login')->plainTextToken;
            return response()->json([ "token" => $token, "status" => 200 ]);
        } else {
            return response()->json([ "status" => 401, "message" => "Wrong Credentials" ]);
        }
    }

    public function logout(Request $request) {
        $token = $request->bearerToken();
        $is_deleted = PersonalAccessToken::findToken($token)->delete();
        if($is_deleted) $request->header("Authentication", "");
        return $is_deleted;
    }
}
