<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $table = "chat_rooms";
    protected $with = [ "user", "company" ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function company() {
        return $this->belongsTo(Company::class);
    }
    protected function chats(): Attribute {
        return Attribute::make(
            get: fn(string $value) => json_decode($value),
            // set: fn(string $value) => json_encode($value)
        );
    }
}
