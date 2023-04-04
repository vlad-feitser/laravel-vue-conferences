<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'date',
        'latitude',
        'longitude',
        'country'
    ];

    public function categories()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_conference');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }
}
