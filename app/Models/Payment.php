<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'jumlah_tamu',
        'total_harga',
        'metode_pembayaran',
        'tanggal_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class, 'id_payments');
    }
}
