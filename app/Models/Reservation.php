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
        'nama_pemesan',
        'email_pemesan',
        'no_telp_pemesan',
        'jumlah_tamu',
        'total_harga',
        'tanggal_reservasi',
        'waktu_reservasi',
        'status_konfirmasi',
    ];

    public function getNamaPemesanAttribute($value)
    {
        return $value ?: ($this->user ? $this->user->nama_lengkap : 'Tamu Cat House');
    }

    public function getEmailPemesanAttribute($value)
    {
        return $value ?: ($this->user ? $this->user->email : '-');
    }

    public function getNoTelpPemesanAttribute($value)
    {
        return $value ?: ($this->user ? $this->user->no_telp : '-');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'id_sesi');
    }
}
