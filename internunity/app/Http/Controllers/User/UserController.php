<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
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
    public function edit(UserEditRequest $request) {

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

        if($request->hasFile("profile_pic") && $token->tokenable->profile_pic) {
            Storage::disk("public")->delete("/profile/{$token->tokenable->profile_pic}");
        }

        $token->tokenable()->update([
            "name" => $name,
            "email" => $email,
            "date_of_birth" => $date_of_birth,
            "profile_pic" => $filename ?? $token->tokenable->profile_pic
        ]);
    }
}
