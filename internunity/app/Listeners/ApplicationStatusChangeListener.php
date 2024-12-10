<?php

namespace App\Listeners;

use App\ApplicationTypes;
use App\Events\Applied;
use App\Events\Interview;
use App\Events\Rejected;
use App\Models\Application;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class ApplicationStatusChangeListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    protected $type = [
        "App\Events\Rejected" => ApplicationTypes::REJECTED->value,
        "App\Events\Interview" => ApplicationTypes::INTERVIEW->value,
        "App\Events\Applied" => ApplicationTypes::APPLIED->value
    ];
    public function __construct()
    {
        //
    }
    /**P
     * Handle the event.
     */
    public function handle(Rejected|Interview|Applied $event): void
    {
        $status = $this->type[get_class($event)];

        // Setting specified status to users
        Application::whereIn("id", $event->applications->pluck("id"))->update([
            "status" => $status
        ]);
        $emails = User::whereIn("id", $event->applications->pluck("user_id"))->get();

        // Sending specific mail to users
        $mailer = "\App\Mail\\" . ucfirst($status);
        foreach($emails as $email) {
            Mail::to($email)->send(new $mailer());
        }
    }
}
