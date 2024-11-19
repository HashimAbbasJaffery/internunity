<?php

namespace App\Http\Controllers;

use App\ApplicationStatus;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use DB;
use Illuminate\Http\Request;
use App\Models\User;

class ApplicationController extends Controller
{
    public function get(User $user) {
        $applications = $user->getUser()->applications()->where("status", request()->type ?: 'applied')->paginate(8)->withQueryString();
        return $applications;
    }
    public function store(ApplicationRequest $request, User $user, $internship) {
        $user->getUser()->applications()->create([...$request->validated(), "internship_id" => $internship]);
        return 1;
    }
}
