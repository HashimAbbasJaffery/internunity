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

    public function get() {
        return $this->sender?->notifications()->unread()->select(["id", "data", "notifiable_id"])->get() ?? [];
    }
}
