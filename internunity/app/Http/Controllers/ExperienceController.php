<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function get(User $user) {
        if(request()->user) {
            return Experience::where("user_id", request()->user)->orderBy("from", "DESC")->paginate(3)->withQueryString();
        }
        $user = $user->getUser();
        return $user->experiences()->orderBy("from", "DESC")->paginate(3);
    }
    public function store(ExperienceRequest $request, User $user) {
        $user = $user->getUser();
        $user->experiences()->create($request->validated());
        return 1;
    }
    public function edit(ExperienceRequest $request, Experience $experience) {
        $experience->update($request->validated());
        return 1;
    }
}
