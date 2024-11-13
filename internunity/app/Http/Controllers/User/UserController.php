<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Storage;

class UserController extends Controller
{
    public function get(Request $request) {
        $token = $request->bearerToken();
        $token = PersonalAccessToken::findToken($token);
        return $token->tokenable()->select(["name", "email", "date_of_birth", "profile_pic"])->first();
    }
    public function edit(Request $request) {

        $request->validate([
            "name" => ["required"],
            "email" => ["email", "required"],
            "date_of_birth" => ["required"]
        ]);

        $name = $request->name;
        $email = $request->email;
        $profile_pic = $request->file("profile_pic");
        $date_of_birth = $request->dob;


        $filename = null;
        if($request->hasFile("profile_pic")) {
            $filename = time() . "." . $profile_pic->extension();
            Storage::disk("public")->putFileAs("/profile", $profile_pic, $filename);
        }

        $token = PersonalAccessToken::find($request->bearerToken());
        $token->tokenable()->update([
            "name" => $name,
            "email" => $email,
            "date_of_birth" => $date_of_birth,
            "profile_pic" => $filename ?? $token->tokenable->profile_pic
        ]);
    }
}
