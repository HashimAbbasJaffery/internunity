<?php

namespace App\Models;

use App\Models\Scopes\ReportedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Macroable;
use Number;

class Internship extends Model
{
    use HasFactory;
    protected $guarded = ["id", "created_at", "updated_at"];
    protected function stipend(): Attribute {
        return Attribute::make(
            get: fn(string $value) =>  Number::format($value)
        );
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }
    public function tags() {
        return $this->belongsToMany(Tag::class, "internship_tags");
    }
    public function hearts() {
        return $this->belongsToMany(User::class, "liked_internships");
    }
    public function applications() {
        return $this->hasMany(Application::class);
    }
    public function isHeartedBy($user_id) {
        return $this->hearts()->where("user_id", $user_id)->exists();
    }
    public function HeartItBy($user_id) {
        $this->hearts()->attach($user_id);
    }
    public function UnHeartItBy($user_id) {
        $this->hearts()->detach($user_id);
    }
    public function HeartOrUnHeartItBy($user_id) {
        if(!$this->isHeartedBy($user_id))
            $this->HeartItBy($user_id);
        else
            $this->UnHeartItBy($user_id);
    }
    public function company() {
        return $this->belongsTo(Company::class);
    }
    public function hires() {
        return $this->hasMany(Hire::class);
    }
}
