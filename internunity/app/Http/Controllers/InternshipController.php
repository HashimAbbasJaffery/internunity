<?php

namespace App\Http\Controllers;

use App\Models\Internship;

class InternshipController extends Controller
{
    public function index(\App\Models\User $user) {
        $keyword = request()->keyword;
        $user_id = $user->getUser()?->id ?? false;
        $relationships = [
            "tags" => fn($query) => $query->where("status", 1),
            "applications" => fn($query) => $query->where("user_id", $user_id),
            "hearts" => fn($query) => $query->where("user_id", $user_id),
        ];
        $internships = Internship::with($relationships)
                                    ->whereDoesntHave("reports", fn($query) => $query->where("user_id", $user_id))
                                    ->where("title", "LIKE", "%$keyword%")
                                    ->whereStatus(1)
                                    ->paginate(8)
                                    ->withQueryString();
        return $internships;
    }
}
