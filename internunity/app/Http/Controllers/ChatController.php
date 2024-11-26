<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function get() {
        SendMessage::dispatch(1, 1, "ll");
    }
}
