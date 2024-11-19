<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index(\App\Models\User $user) {
        $keyword = request()->keyword;
        $internships = Internship::with(["tags" => fn($query) => $query->where("status", 1), "applications" => fn($query) => $query->where("user_id", $user->getUser()?->id ?? false)])
                                    ->where("title", "LIKE", "%" . $keyword . "%")
                                    ->whereStatus(1)
                                    ->paginate(8)
                                    ->withQueryString();
        return $internships;
    }
}
