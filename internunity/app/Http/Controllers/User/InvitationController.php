<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationInvitation;
use App\Models\Company;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Mail;

class InvitationController extends Controller
{
    public function invite(Request $request, Internship $internship) {
        $company = (PersonalAccessToken::findToken(request()->bearerToken()))->tokenable;

        // Check if the company exists
        if(!$company) return;

        // Check if the company is the owner of the internship
        if($company->id !== $internship->company_id) return;

        $request->validate([
            "email" => "required|email"
        ]);

        $email = $request->email;
        $user = User::where("email", $email)->first();
        $name = $request->name;

        if($internship->invitations()->where("user_id", $user->id)->exists()) {
            return response()->json(["message" => "User already invited"], 400);
        }

        try {
            Mail::to($email)->queue(new ApplicationInvitation($internship, $company, $name));
            $internship->invitations()->attach($user);
        } catch(\Exception $e) {
            return response()->json(["message" => "Failed to send invitation"], 500);
        }

        return response()->json(["message" => "Invitation sent"], 200);
    }
}
