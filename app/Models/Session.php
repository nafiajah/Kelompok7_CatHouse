<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    public $timestamps = false;

    protected $fillable = [
        'jam_sesi',
        'token_sesi',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_sesi');
    }
}
