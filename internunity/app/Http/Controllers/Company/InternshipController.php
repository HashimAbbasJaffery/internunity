<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternshipCreateRequest;
use App\Models\Internship;
use App\Models\Tag;
use DB;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Validator;

class InternshipController extends Controller
{
    public function get(Request $request) {
        $keyword = $request->keyword;
        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;
        return $company->internships()->select(["id", "title", "description", "stipend", "status", "created_at"])
                        ->with("tags")
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
    // InternshipCreateRequest
    public function store(InternshipCreateRequest $request) {
        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;

        // Attaching tags if incoming tag is new
        $internship_tags = collect($request->tags);
        $all_tags = Tag::all()->pluck("id");
        $tags_to_add = $internship_tags->pluck("id")->diff($all_tags);
        foreach($tags_to_add as $tag) {
            $tag = $internship_tags->where("id", $tag)->first();
            Tag::create([
                "id" => $tag["id"],
                "tag" => $tag["name"],
                "status" => 1
            ]);
        }

        DB::transaction(function() use($request, $company, $internship_tags) {

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
            if(!$internship_tags->pluck("id")) DB::rollBack();
            // Attach tags
            $internship->tags()->sync($internship_tags->pluck("id"));
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

          // Attaching tags if incoming tag is new
          $internship_tags = collect($request->tags);
          $all_tags = Tag::all()->pluck("id");
          $tags_to_add = $internship_tags->pluck("id")->diff($all_tags);
          foreach($tags_to_add as $tag) {
              $tag = $internship_tags->where("id", $tag)->first();
              Tag::create([
                  "id" => $tag["id"],
                  "tag" => $tag["name"],
                  "status" => 1
              ]);
          }

        $company = (PersonalAccessToken::findToken($request->bearerToken()))->tokenable;

        if($internship->company_id !== $company->id) return [ "message" => 'Unauthorized', "status" => 403 ];
        DB::transaction(function() use($request, $company, $internship, $internship_tags) {
            $internship->update([
                "title" => $request->title,
                "description" => $request->description,
                "stipend" => $request->stipend,
                "company_id" => $company->id,
                "status" => 1
            ]);

            // If there are no tags then rollback all previous transactions
            if(!$internship_tags->pluck("id")) DB::rollBack();
            // Attach tags
            $internship->tags()->sync($internship_tags->pluck("id"));
        });

        return 1;
    }
    public function get_by_id(Internship $internship) {
        return $internship->load(["tags"])->only(["id", "title", "description", "stipend", "tags"]);
    }
}
