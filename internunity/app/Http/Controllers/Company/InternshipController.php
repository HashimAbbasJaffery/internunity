<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternshipCreateRequest;
use App\Models\Internship;
use DB;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Validator;

class InternshipController extends Controller
{
    public function get(Request $request) {
        $keyword = $request->keyword;
        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;
        return $company->internships()->select(["title", "description", "stipend", "status", "created_at"])
                        ->latest()
                        ->orderBy("created_at", "desc")
                        ->withCount("applications")
                        ->whereLike('title', "%$keyword%")
                        ->paginate(8);
    }
    public function delete(Request $request, Internship $internship) {
        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;
        if($company->id !== $internship->company_id) return [ "message" => 'Unauthorized', "status" => 403 ];
        $is_deleted = $internship->delete();
        return $is_deleted;
    }
    public function store(InternshipCreateRequest $request) {

        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;

        DB::transaction(function() use($request, $company) {

            // Deducting amount from the wallet
            if($company->wallet->balance < 5) return;
            $company->wallet->balance -= 5;
            $company->wallet->save();

            // Posting internship
            $internship = Internship::create([
                "title" => $request->title,
                "description" => $request->description,
                "stipend" => $request->stipend,
                "company_id" => $company->id,
                "status" => 1
            ]);

            // If there are no tags then rollback all previous transactions
            if(!json_decode($request->tags)) DB::rollBack();

            // Attach tags
            $internship->tags()->sync(json_decode($request->tags));
        });

        return 1;
    }

    public function update(Request $request, Internship $internship) {
        $request->validate([
            "title" => ["required"],
            "description" => ["required"],
            "stipend" => ["required"],
            "tags" => ["required"]
        ]);

        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;

        if($internship->company_id !== $company->id) return [ "message" => 'Unauthorized', "status" => 403 ];
        DB::transaction(function() use($request, $company, $internship) {
            $internship->update([
                "title" => $request->title,
                "description" => $request->description,
                "stipend" => $request->stipend,
                "company_id" => $company->id,
                "status" => 1
            ]);

            if(!json_decode($request->tags)) DB::rollBack();

            $internship->tags()->sync(json_decode($request->tags));
        });

        return 1;
    }
}
