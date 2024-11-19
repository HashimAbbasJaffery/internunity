<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\User;

class ApplicationStatusController extends Controller
{
    public function get(User $user) {
        $status = $user->getUser()->applications()->selectRaw("COUNT(*) as count, status")->groupBy("status")->get();
        // $status = Application::selectRaw("COUNT(*) as count, status")->groupBy("status")->get();
        return ["data" => $status];
    }
}
