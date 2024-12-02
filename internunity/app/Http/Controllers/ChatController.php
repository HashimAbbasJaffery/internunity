<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Http\Requests\ChatRequest;
use App\Models\ChatRoom;
use App\Models\Company;
use App\Models\User;
use App\Notifications\UserNotification;
use App\PayloadGenerator;
use App\Services\Communication;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(
        protected PayloadGenerator $payload,
        protected Communication $communication
    ) {}
    public function get() {
        SendMessage::dispatch(1, 1, "ll");
    }
    public function store(ChatRequest $request) {
        $type = $request->sender;

        // Finding the room (if exists otherwise creating new room)
        $condition = [
            "company_id" => $request->company_id,
            "user_id" => $request->user_id
        ];

        $chat_room = ChatRoom::firstOrCreate([
            ...$condition
        ], [
            "chats" => "[]",
            "status" => 1,
            "is_read" => 0
        ]);

        // Determining who is the receiever on the other end
        [ $sender, $receiver ] = $this->communication->between($request->user_id, $request->company_id, $type);
        $extras = $this->payload->generateForChat($request, $chat_room);

        $chat_room->update([
            "chats" => [...$chat_room->chats, ["message" => request()->message, "from" => $type]],
            "is_read" => false
        ]);

        if(!$receiver->has_notifications) {
            $receiver->has_notifications = true;
            $receiver->save();
        }


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
