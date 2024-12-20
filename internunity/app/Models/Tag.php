<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = ["created_at", "updated_at"];
    protected $primaryKey = 'id'; // Or your custom primary key
    protected $keyType = 'string';
    public $incrementing = false;
    public function internships() {
        return $this->belongsToMany(Internship::class);
    }
}
