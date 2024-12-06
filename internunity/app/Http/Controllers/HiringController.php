<?php

namespace App\Http\Controllers;

use App\ApplicationTypes;
use App\Events\Hired;
use App\Events\Rejected;
use App\Models\Application;
use App\Models\Internship;
use DB;
use Illuminate\Http\Request;

class HiringController extends Controller
{
    public function hire(Request $request, Internship $internship) {

        $user_id = request()->user_id;
        $hiree_application = $internship
                                    ->applications()
                                    ->where("user_id", $user_id)
                                    ->where("internship_id", $internship->id)
                                    ->first();

        $hiree_application->internship->hires()->create([
            "user_id" => $user_id
        ]);

        Hired::dispatch($hiree_application);
    }

    public function close(Internship $internship) {
        $rejected_application = Application::query()
            ->join('users', 'applications.user_id', '=', second: 'users.id')
            ->leftJoin('hires', 'applications.user_id', '=', 'hires.user_id')
            ->whereNull('hires.user_id')
            ->where('applications.internship_id', 55)
            ->select("applications.id", "users.email")
            ->get();

        $internship->status = 0;
        $internship->save();

        Rejected::dispatch($rejected_application);
    }

    public function shortlist(Request $request, Internship $internship) {
        $shortlisted_candidates = json_decode($request->candidates_id);

        $rejected_candidates = $internship->applications()->select("id", "user_id")->whereNotIn("user_id", $shortlisted_candidates)->get();
        $internship->applications()->whereIn("user_id", $shortlisted_candidates)->update([
            "status" => ApplicationTypes::INTERVIEW->value
        ]);

        Rejected::dispatch($rejected_candidates);
    }
}
