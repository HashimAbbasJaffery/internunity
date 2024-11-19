<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $with = ["internship"];
    protected $guarded = ["id", "created_at", "updated_at"];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function internship() {
        return $this->belongsTo(Internship::class);
    }
}
