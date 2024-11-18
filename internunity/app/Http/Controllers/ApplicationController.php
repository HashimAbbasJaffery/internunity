<?php

namespace App\Http\Controllers;

use App\ApplicationStatus;
use App\Models\Application;
use DB;
use Illuminate\Http\Request;
use App\Models\User;

class ApplicationController extends Controller
{
    public function get(User $user) {
        // $counts = Application::selectRaw('COUNT(*) as count, status')->groupBy("status")->get();
        $applications = $user->getUser()->applications()->where("status", request()->type ?: 'applied')->paginate(8)->withQueryString();
        return $applications;
    }
}
