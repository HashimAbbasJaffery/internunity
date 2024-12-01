<?php

namespace App;

use App\Models\ChatRoom;
use App\Models\User;
use Request;

class PayloadGenerator
{
    /**
     * Create a new class instance.
     */
    public function generateForChat(object $request, $room) {
        $extras = [];
        if($room) {
            $extras["room"] = [
                "id" => $room->id,
                "company_id" => $room->company_id,
                "user_id" => $room->user_id,
                "chats" => json_encode($room->chats),
                "status" => $room->status,
                "is_read" => $room->is_read,
                "company" => [
                    "profile_pic" => $room->company->profile_pic,
                    "name" => $room->company->name
                ],
                "user" => [
                    "profile_pic" => $room->user->profile_pic,
                    "name" => $room->user->name
                ]
            ];
        }
        if($request->company_id) {
            $extras["company_id"] = $request->company_id;
        }
        if($request->user_id) {
            $extras["user_id"] = $request->user_id;
        }
        $extras["type"] = request()->type;
        return $extras;
    }
}
