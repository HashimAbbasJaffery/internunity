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
    public function get() {
        $keyword = request()->q;

        $company = (PersonalAccessToken::findToken(request()->bearerToken()))->tokenable;
        $users = User::with(["skills:tag,id", "heartedByCompany" => fn($query) => $query->where("heartable_id", $company->id)])
                        ->withCount(relations: "heartedByCompany")
                        ->whereLike("tagline", "%$keyword%")
                        ->orWhereLike("name", "%$keyword%")
                        ->orwhereHas("skills", fn(Builder $query) => $query->whereLike("tag", "%$keyword%"))
                        ->orderBy("hearted_by_company_count", "desc")
                        ->paginate(8)
                        ->withQueryString();
        return $users;
    }
}
