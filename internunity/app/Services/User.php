<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken;

class User
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function get() {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        return $token->tokenable;
    }
    public function has(Model $model) {
        return $model;
    }
}
