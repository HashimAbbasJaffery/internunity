<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hearted_internships() {
        return $this->belongsToMany(Internship::class, "liked_internship");
    }
    public function projects() {
        return $this->hasMany(Project::class);
    }
    public function experiences() {
        return $this->hasMany(Experience::class);
    }
    public function educations() {
        return $this->hasMany(Education::class);
    }
    public function applications() {
        return $this->hasMany(Application::class);
    }
    public function getUser() {{
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        return $token->tokenable;
    }}
    public function isOwnerOf(Model $model) {
        return $model->user_id === ($this->getUser())->id;
    }
}
