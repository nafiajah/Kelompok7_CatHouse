<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'id_user',
        'tanggal_reservasi',
        'waktu_reservasi',
        'id_sesi',
        'id_pembayaran',
    ];
    public $timestamps = false;

}
