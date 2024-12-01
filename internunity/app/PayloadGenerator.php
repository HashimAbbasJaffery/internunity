<?php

namespace App;

use App\Models\User;
use Request;

class PayloadGenerator
{
    /**
     * Create a new class instance.
     */
    protected $sender;
    public function __construct(User $user) {
        $this->sender = $user->getUser();
    }
    public function generateForChat(object $request) {
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
        return $extras;
    }
}
