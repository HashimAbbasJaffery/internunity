<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hire extends Model
{
    protected $guarded = ["id", "created_at", "updated_at"];
    public function hired() {
        return $this->belongsTo(User::class);
    }
    public function internship() {
        return $this->belongsTo(Internship::class);
    }
}
