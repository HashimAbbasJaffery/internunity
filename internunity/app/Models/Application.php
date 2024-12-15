<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function coverLetter(): Attribute {
        return Attribute::make(
            get: fn($value) => nl2br(e($value))
        );
    }
}
