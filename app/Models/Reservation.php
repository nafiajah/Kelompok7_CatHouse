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
        'tanggal_reservasi',
        'waktu_reservasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_reservasi');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'id_sesi');
    }
}
