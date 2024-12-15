<?php

namespace App\Http\Controllers;

use App\ApplicationTypes;
use App\Events\Hired;
use App\Events\Interview;
use App\Events\Rejected;
use App\Models\Application;
use App\Models\Internship;
use DB;
use Illuminate\Http\Request;
use Mail;

class HiringController extends Controller
{
    public function hire(Application $application) {
        if($application->status === ApplicationTypes::SELECTED->value) return;

        $application->status = ApplicationTypes::SELECTED->value;
        $application->save();

        $application->internship->hires()->create([
            "user_id" => $application->user_id
        ]);

        Mail::to($application->user->email)->queue(new \App\Mail\Hired());
    }

    public function close(Internship $internship) {
        $rejected_application = $internship
                    ->applications()
                    ->whereIn("status", [ApplicationTypes::APPLIED->value, ApplicationTypes::INTERVIEW->value])
                    ->get();

        $internship->status = 0;
        $internship->save();

        Rejected::dispatch($rejected_application);
        return 1;
    }


    public function shortlist(Request $request, Internship $internship) {
        $shortlisted_candidates = json_decode($request->candidates_id);

        $rejected_candidates = $internship->applications()->select("id", "user_id")->whereNotIn("user_id", $shortlisted_candidates)->get();
        $interviewing_candidates = $internship->applications()->select("id", "user_id")->whereIn("user_id", $shortlisted_candidates)->get();
        $internship->applications()->whereIn("user_id", $shortlisted_candidates)->update([
            "status" => ApplicationTypes::INTERVIEW->value
        ]);

        Rejected::dispatch($rejected_candidates);
        Interview::dispatch($interviewing_candidates);
    }
    public function reject(Application $application) {
        if($application->status === ApplicationTypes::REJECTED->value) return;

        $application->status = ApplicationTypes::REJECTED->value;
        $application->save();

        Mail::to($application->user->email)->queue(new \App\Mail\Rejected());
    }
}
