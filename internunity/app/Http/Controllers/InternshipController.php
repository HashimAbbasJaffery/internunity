<?php

namespace App\Http\Controllers;

use App\Models\Internship;

class InternshipController extends Controller
{
    public function index(\App\Models\User $user) {
        $keyword = request()->keyword;
        $user_id = $user->getUser()?->id ?? false;
        $skill_ids = $user->getUser()?->skills->map(fn($skill) => $skill->pivot->tag_id) ?? false;

        $relationships = [
            "tags" => fn($query) => $query->where("status", 1),
            "applications" => fn($query) => $query->where("user_id", $user_id),
            "hearts" => fn($query) => $query->where("user_id", $user_id),
        ];

        $internships = Internship::when($user_id, function($query) use($relationships, $skill_ids, $user_id){
                                    $query->with($relationships)
                                        ->whereHas("tags", fn($query) => $query->whereIn("tag_id", $skill_ids))
                                        ->whereDoesntHave("reports", fn($query) => $query->where("user_id", $user_id));
                                }, function($query) {
                                    $query->with(["tags"]);
                                })
                                ->where("title", "LIKE", "%$keyword%")
                                ->whereStatus(1)
                                ->latest()
                                ->paginate(8)
                                ->withQueryString();
        return $internships;
    }
}
