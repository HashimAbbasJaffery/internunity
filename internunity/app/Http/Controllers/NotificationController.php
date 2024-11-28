<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $sender;
    public function __construct(User $user) {
        $this->sender = $user->getUser();
    }
    public function notify(Request $request, $receiver) {
        $request->validate([
            "message" => [ "required" ],
            "type" => [ "required" ]
        ]);
        $receiver = User::find($receiver);

        $extras = [];
        if($this->sender) {
            $extras["sender_name"] = $this->sender->name;
        }
        $extras["type"] = request()->type;

        $receiver->notify(new UserNotification(request()->message, request()->type, $extras));
    }
    public function get() {
        return $this->sender?->notifications->select(["id", "data", "notifiable_id"]) ?? [];
    }
}
