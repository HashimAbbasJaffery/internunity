<?php

namespace App\Listeners;

use App\ApplicationTypes;
use App\Events\Interview;
use App\Events\Rejected;
use App\Jobs\SendEmails;
use App\Models\Application;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Log;

class ApplicationStatusChangeListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }


    /**P
     * Handle the event.
     */
    public function handle(Rejected|Interview $event): void
    {
        // Setting status to rejected to all rejected candidates
        Application::whereIn("id", $event->applications->pluck("id"))->update([
            "status" => ApplicationTypes::REJECTED->value
        ]);
        $emails = User::whereIn("id", $event->applications->pluck("user_id"))->get();

        // Sending Rejection Emails to unselected candidates
        foreach($emails as $email) {
            Mail::to($email)->send(new \App\Mail\Rejected());
        }
    }
}
