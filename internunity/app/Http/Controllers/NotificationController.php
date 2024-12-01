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
        if($request->company_id) {
            $extras["company_id"] = $request->company_id;
        }
        if($request->user_id) {
            $extras["user_id"] = $request->user_id;
        }
        $extras["type"] = request()->type;
        $extras["is_read"] = false;


        $receiver->notify(new UserNotification(request()->message, request()->type, $extras));
    }
    public function get() {
        return $this->sender?->notifications->select(["id", "data", "notifiable_id"]) ?? [];
    }
}
