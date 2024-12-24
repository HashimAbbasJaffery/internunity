<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Faker\Provider\ar_EG\Person;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function get(Request $request) {
        $keyword = $request->q;
        $skill_ids = $request->token ? explode("|", $request->token) : '';
        $company = (PersonalAccessToken::findToken(request()->bearerToken()))->tokenable;
        $users = User::with(["skills:tag,id", "heartedByCompany" => fn($query) => $query->where("heartable_id", $company->id)])
                        ->withCount(relations: "heartedByCompany")
                        ->whereLike("tagline", "%$keyword%")
                        ->orWhereLike("name", "%$keyword%")
                        ->when($skill_ids, function($query) use($skill_ids) {
                            $query->with("invitations:id")->whereHas("skills", fn($query) => $query->whereIn("tag_id", $skill_ids));
                        }, function($query) use ($keyword) {
                            $query->orWhereHas("skills", fn(Builder $query) => $query->whereLike("tag", "%$keyword%"));
                        })
                        ->orderBy("hearted_by_company_count", "desc")
                        ->paginate(8)
                        ->withQueryString();
        return $users;
    }
    public function get_by_id(User $user) {
        return $user->select(["id", "name", "profile_pic"])->find($user->id);
    }
    public function get_chatrooms(Request $request) {
        $company = (PersonalAccessToken::findToken(request()->bearerToken()))->tokenable;
        return $company->chatrooms()->with(["user:id,name,profile_pic"])->get();
    }
}
