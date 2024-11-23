<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportCreateRequest;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(ReportCreateRequest $request, User $user, Internship $internship) {
        $user->getUser()->reports()->create([...$request->validated(), "internship_id" => $internship->id]);
        return 1;
    }
}
