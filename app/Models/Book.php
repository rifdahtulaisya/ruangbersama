<?php
// app/Models/Book.php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id', 'title', 'author', 'image', 'stock'];
    protected $dates = ['deleted_at'];

    // Book N - 1 Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Book 1 - N Loan
    public function loans()
    {
        return $this->hasMany(Loan::class, 'id_books');
    }
    
    // Method untuk mengurangi stok
    public function decrementStock($amount = 1)
    {
        if ($this->stock >= $amount) {
            $this->stock -= $amount;
            $this->save();
            return true;
        }
        return false;
    }

    // Method untuk menambah stok
    public function incrementStock($amount = 1)
    {
        $this->stock += $amount;
        $this->save();
        return true;
    }
}