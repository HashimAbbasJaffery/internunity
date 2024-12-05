<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    public function get(Internship $internship) {
        return $internship->load(["applications" => fn($query) => $query->with("user")]);
    }
}
