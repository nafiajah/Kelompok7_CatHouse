<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'tanggal_saran',
        'teks_saran',
        'bintang',
        'status_tampil',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
