<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioCreateRequest;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class PortfolioController extends Controller
{
    public function get(Request $request) {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        return $token->tokenable->projects()->paginate(14);
    }
    public function store(PortfolioCreateRequest $request) {

        $token = PersonalAccessToken::findToken($request->bearerToken());
        $token->tokenable->projects()->create([ ...$request->validated(), "to" => now(), "from" => now() ]);
    }
}
