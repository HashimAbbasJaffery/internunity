<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UserHeartLikesController extends Controller
{
    public function __construct( protected Company $company ) {}
    public function heart(User $user) {
        $company = (PersonalAccessToken::findToken(request()->bearerToken()))->tokenable;
        $company->profileHearts()->toggle($user->id);
        return 1;
    }
}
