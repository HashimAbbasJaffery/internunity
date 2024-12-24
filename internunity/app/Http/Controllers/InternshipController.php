<?php

namespace App\Http\Controllers;

use App\Models\Internship;

class InternshipController extends Controller
{
    public function index(\App\Models\User $user) {
        $keyword = request()->keyword;
        $user_id = $user->getUser()?->id ?? false;
        $skill_ids = $user->getUser()?->skills->map(fn($skill) => $skill->pivot->tag_id) ?? false;
        $internship_id = request()->internship_id;
        $relationships = [
            "tags" => fn($query) => $query->where("status", 1),
            "applications" => fn($query) => $query->where("user_id", $user_id),
            "hearts" => fn($query) => $query->where("user_id", $user_id),
        ];

        if($internship_id) {
            $internship = Internship::with($relationships)
                                    ->where("id", $internship_id)
                                    ->whereStatus(1)
                                    ->paginate(8);
            return $internship;
        }

        $internships = Internship::when($user_id, function($query) use($relationships, $skill_ids, $user_id, $internship_id){
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
