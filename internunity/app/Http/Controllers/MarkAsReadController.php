<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Notification;

class MarkAsReadController extends Controller
{
    protected $sender;
    public function __construct(User $user) {
        $this->sender = $user->getUserCallable();
    }
    public function edit() {
        $this->sender->update([
            "has_notifications" => 0
        ]);
        return 1;
    }
}
