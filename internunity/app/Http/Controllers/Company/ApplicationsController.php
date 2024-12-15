<?php

namespace App\Http\Controllers\Company;

use App\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    public function get(Internship $internship) {
        return $internship->load(["applications" => fn($query) => $query->with("user")]);
    }
    public function get_by_internship(Internship $internship) {
        return $internship->applications()->whereNot("status", ApplicationStatus::REJECTED->value)->with("user")->paginate(1);
    }
}
