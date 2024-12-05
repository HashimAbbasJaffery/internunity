<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use DB;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Validator;

class InternshipController extends Controller
{
    public function get(Request $request) {
        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable();
        return $company->with(["internships" => fn($query) => $query->withCount("applications")])->get();
    }
    public function delete(Request $request, Internship $internship) {
        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;
        if($company->id !== $internship->company_id) return [ "message" => 'Unauthorized', "status" => 403 ];
        $is_deleted = $internship->delete();
        return $is_deleted;
    }
    public function store(Request $request) {
        $request->validate([
            "title" => ["required"],
            "description" => ["required"],
            "stipend" => ["required"],
            "tags" => ["required"]
        ]);

        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;

        DB::transaction(function() use($request, $company) {
            $internship = Internship::create([
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

    public function update(Request $request, Internship $internship) {
        $request->validate([
            "title" => ["required"],
            "description" => ["required"],
            "stipend" => ["required"],
            "tags" => ["required"]
        ]);

        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;

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
