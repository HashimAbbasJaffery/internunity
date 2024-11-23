<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;

class HeartActionController extends Controller
{
    public function store(User $user, Internship $internship) {
        $user = $user->getUser();
        $internship->HeartOrUnHeartItBy($user->id);
        return 1;
    }
}
