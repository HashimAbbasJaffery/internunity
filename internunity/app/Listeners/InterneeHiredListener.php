<?php

namespace App\Listeners;

use App\ApplicationTypes;
use App\Events\Hired;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class InterneeHiredListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Hired $event): void
    {
        $event->application->status = ApplicationTypes::SELECTED->value;
        $event->application->save();

        Mail::to($event->application->user)->send(new \App\Mail\Hired());
    }
}
