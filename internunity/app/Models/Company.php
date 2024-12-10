<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model
{
    use HasFactory, HasApiTokens;
    protected $guarded = ["id", "created_at", "updated_at"];
    public function internships() {
        return $this->hasMany(Internship::class);
    }
    public function wallet() {
        return $this->morphOne(Wallet::class, "walletable");
    }
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
