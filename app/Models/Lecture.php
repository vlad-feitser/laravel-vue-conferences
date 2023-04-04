<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'conference_id', 'category_id', 'title', 'start_time', 'end_time', 'description', 'presentation'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function usersFavorites()
    {
        return $this->hasMany(User::class, 'user_lecture');
    }

    public function categories()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
