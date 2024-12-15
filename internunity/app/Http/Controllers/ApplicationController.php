<?php

namespace App\Http\Controllers;

use App\Events\Applied;
use App\Http\Requests\ApplicationRequest;
use App\Models\Internship;
use App\Services\File;
use App\Models\User;

class ApplicationController extends Controller
{
    public function get(User $user) {
        $user_id = $user->getUser()?->id ?? false;
        $relationships = [
            "internship.hearts" => fn($query) => $query->where("user_id", $user_id)
        ];
        $applications = $user->getUser()
                                ->applications()
                                ->with($relationships)
                                ->whereDoesntHave("internship.reports", fn($query) => $query->where("user_id", $user_id))
                                ->where("status", request()->type ?: 'applied')
                                ->paginate(8)
                                ->withQueryString();
        return $applications;
    }

    public function store(ApplicationRequest $request, User $user, $internship, File $file) {
        $applications = $user->getUser()->applications();
        if($applications->where("internship_id", $internship)->exists()) abort(403);
        $resume = $file->upload($request->file("resume"), 'public', '/resumes/');
        $application = $applications->create([...$request->validated(), "internship_id" => $internship, "resume" => $resume]);
        return 1;
    }
}
