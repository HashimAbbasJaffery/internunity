<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = ["id", "created_at", "updated_at"];
    public function unread() {
        return $this->whereNull("read_at");
    }
}
