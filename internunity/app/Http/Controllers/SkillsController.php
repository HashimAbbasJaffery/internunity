<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    public function __construct(protected User $user) {}
    public function store(Request $request) {
        $skills_id = request()->skills_id;

        $request->validate([
            "skills_id" => [ "required" ]
        ]);
        $user = $this->user->getUser();

        $does_exist = $user->skills()->where("tag_id", $skills_id)->exists();

        if(!$does_exist)
            $user->skills()->attach($skills_id);

        return 1;
    }
}
