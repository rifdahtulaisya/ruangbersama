<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['category_id', 'room_name', 'image', 'location'];

    // Room N - 1 Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
