<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    public $timestamps = false;

    protected $fillable = [
        'id_users',
        'id_sesi',
        'jumlah_tamu',
        'total_harga',
        'tanggal_reservasi',
        'waktu_reservasi',
        'status_konfirmasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'id_sesi');
    }
}
