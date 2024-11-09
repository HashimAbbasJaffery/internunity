<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function get(Request $request) {
        $token = $request->bearerToken();
        $token = PersonalAccessToken::findToken($token);
        return $token->tokenable()->select(["name", "email", "date_of_birth", "profile_pic"])->first();
    }
    public function edit(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $date_of_birth = $request->dob;

        $token = PersonalAccessToken::find($request->bearerToken());
        $token->tokenable()->update([
            "name" => $name,
            "email" => $email,
            "date_of_birth" => $date_of_birth
        ]);
    }
}
