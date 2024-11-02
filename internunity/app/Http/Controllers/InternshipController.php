<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index() {
        $internships = Internship::with(["tags" => fn($query) => $query->where("status", 1)])
                                    ->whereStatus(1)
                                    ->paginate(8)
                                    ->withQueryString();
        return $internships;
    }
}
