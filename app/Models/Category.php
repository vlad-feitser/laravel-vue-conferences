<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_category_id'];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'category_id', 'id');
    }

    public function lectures()
    {
        return $this->belongsToMany(Conference::class, 'category_id', 'id');
    }
}
