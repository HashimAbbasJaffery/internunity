<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationRequest;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Models\User;

class EducationController extends Controller
{
    public function get(User $user) {
        if(request()->user) {
            return Education::where("user_id", request()->user)->orderBy("from", "DESC")->paginate(3)->withQueryString();
        }
        $user = $user->getUser();
        return $user->educations()->orderBy("from", "DESC")->paginate(3);
    }
    public function store(EducationRequest $request, User $user) {
        $user = $user->getUser();
        $user->educations()->create($request->validated());
        return 1;
    }
    public function edit(EducationRequest $request, Education $education) {
        $education->update($request->validated());
        return 1;
    }
}
