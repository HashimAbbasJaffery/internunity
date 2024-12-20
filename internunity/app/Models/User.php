<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Mockery\Undefined;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, Notifiable;

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

    public function HeartedByLoggedCompanyId(): Attribute {
        $loggedUser = (PersonalAccessToken::findToken(request()->bearerToken()))->tokenable;
        return Attribute::make(
            get: fn($query) => $query->heartedByCompany()->where("id", $loggedUser->user)
        );
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
    public function reports() {
        return $this->hasMany(Report::class);
    }
    public function getUser() {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        return $token?->tokenable ?? null;
    }
    public function getUserCallable() {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        return $token?->tokenable() ?? null;
    }
    public function isOwnerOf(Model $model) {
        return $model->user_id === ($this->getUser())->id;
    }
    public function chat_rooms() {
        return $this->hasMany(ChatRoom::class, "user_id");
    }
    public function hires() {
        return $this->hasMany(Hire::class);
    }
    public function skills() {
        return $this->belongsToMany(Tag::class, "tags_users")->withPivot("id", "tag_id", "user_id");
    }
    public function profileHearts() {
        return $this->morphToMany(User::class, 'heartable', 'user_hearts');
    }
    public function heartedByUser() {
        return $this->morphedByMany(User::class, 'heartable', 'user_hearts');
    }
    public function heartedByCompany() {
        return $this->morphedByMany(Company::class, 'heartable', 'user_hearts');
    }

}
