<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id', 'title', 'author', 'image', 'stock'];
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'id_books');
    }

    public function decrementStock($amount = 1)
    {
        if ($this->stock >= $amount) {
            $this->stock -= $amount;
            $this->save();
            return true;
        }
        return false;
    }

    public function incrementStock($amount = 1)
    {
        $this->stock += $amount;
        $this->save();
        return true;
    }
}
