<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    // Relasi: satu user memiliki banyak artikel
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');  // Relasi one to many dengan Article
    }

    // Relasi: satu user bisa memiliki banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');  // Relasi one to many dengan Comment
    }

    // Relasi: satu user memiliki satu profil ahli
    public function expertProfile()
    {
        return $this->hasOne(ExpertProfile::class, 'user_id');  // Relasi one to one dengan ExpertProfile
    }

    // Relasi: satu user memiliki banyak like
    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');  // Relasi one to many dengan Like
    }

    // Relasi: satu user memiliki banyak pemberitahuan
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');  // Relasi one to many dengan Notification
    }

    // Relasi: satu user memiliki banyak log pencarian
    public function searchLogs()
    {
        return $this->hasMany(SearchLog::class, 'user_id');  // Relasi one to many dengan SearchLog
    }
}
