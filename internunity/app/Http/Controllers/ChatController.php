<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Http\Requests\ChatRequest;
use App\Models\ChatRoom;
use App\Models\User;
use App\Notifications\UserNotification;
use App\PayloadGenerator;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $sender;
    public function __construct(User $user) {
        $this->sender = $user->getUser();
    }
    public function get() {
        SendMessage::dispatch(1, 1, "ll");
    }
    public function store(ChatRequest $request, int $room, PayloadGenerator $payload) {
        $chat_room = ChatRoom::find($room);
        $receiver = User::find( $request->sender === 'user' ? $chat_room->company_id : $chat_room->user_id);

        $extras = $payload->generateForChat($request);

        $chat_room->update([
            "chats" => [...$chat_room->chats, ["message" => request()->message, "from" => $request->sender === 'user' ? 'company' : 'user']],
            "is_read" => false
        ]);


        // Send Realtime notification
        $receiver->notify(new UserNotification(request()->message, request()->type, $extras));
    }
    public function changeStatus(int $room) {
        $room = ChatRoom::find($room);

        $room->update([
            "is_read" => true
        ]);

        return 1;
    }
}
