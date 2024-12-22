<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\SkillsActionTypes;
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
    public function get(Request $request) {
        $skills = Tag::whereLike("tag", "%$request->q%")->get();
        return $skills;
    }
    public function add(Request $request) {
        $skill = $request->skill;
        $user = $this->user->getUser();
        if($request->type === SkillsActionTypes::ADD->value) {
            $user->skills()->attach($skill["id"]);
        } else {
            $user->skills()->detach($skill["id"]);
        }
        return 1;
    }
    public function get_user_skills(User $user) {
        return $user->skills;
    }
}
