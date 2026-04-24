<?php
// app/Models/Loan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans';
    
    protected $fillable = [
        'id_users',
        'id_books',
        'tgl_pinjam',
        'tgl_kembali_rencana',
        'tgl_kembali_realisasi',
        'status',
        'returned_at'
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali_rencana' => 'date',
        'tgl_kembali_realisasi' => 'date',
        'returned_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_books');
    }

     public function isReturned()
    {
        return !is_null($this->returned_at);
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_BORROWED = 'borrowed';
    const STATUS_RETURNED = 'returned';
    const STATUS_CANCELLED = 'cancelled';
}