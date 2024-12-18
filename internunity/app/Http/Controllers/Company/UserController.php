<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get() {
        $keyword = request()->q;
        $users = User::select(["id", "name", "profile_pic", "tagline"])
                        ->with("skills:tag,id")
                        ->whereLike("tagline", "%$keyword%")
                        ->orWhereLike("name", "%$keyword%")
                        ->orwhereHas("skills", fn(Builder $query) => $query->whereLike("tag", "%$keyword%"))
                        ->paginate(8)
                        ->withQueryString();
        return $users;
    }
}
