<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'type',
        'birthdate',
        'country',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'user_conference');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function lecturesFavorites()
    {
        return $this->belongsToMany(Lecture::class, 'user_lecture');
    }
}
