<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    
    protected $fillable = [
        'id_users',
        'id_rooms',
        'tgl_pinjam',
        'tgl_kembali_rencana',
        'tgl_kembali_realisasi',
        'status',
        'teguran'
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali_rencana' => 'date',
        'tgl_kembali_realisasi' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'id_rooms');
    }
}