<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index() {
        $keyword = request()->keyword;
        $internships = Internship::with(["tags" => fn($query) => $query->where("status", 1)])
                                    ->where("title", "LIKE", "%" . $keyword . "%")
                                    ->whereStatus(1)
                                    ->paginate(8)
                                    ->withQueryString();
        return $internships;
    }
}
