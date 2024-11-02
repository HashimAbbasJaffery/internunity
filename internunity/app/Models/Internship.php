<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;
    public function tags() {
        return $this->belongsToMany(Tag::class, "internship_tags");
    }
    public function hearted_by() {
        return $this->belongsToMany(User::class, "liked_internships");
    }
}
