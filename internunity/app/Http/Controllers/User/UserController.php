<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\PersonalAccessToken;
use Storage;

class UserController extends Controller
{
    public function get(Request $request) {

        // Each Token represents the Logged in each device
        $token = $request->bearerToken();
        $data = Cache::remember($token, now()->addHour(), function() use ($token) {
            $token = PersonalAccessToken::findToken($token);
            return $token->tokenable()->select(columns: ["id", "name", "email", "date_of_birth", "profile_pic"])->first();
        });
        return $data;

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

        cache()->forget($request->bearerToken());
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
