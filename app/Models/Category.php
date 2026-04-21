<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name'];

    // Category 1 - N Room
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
