<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['id_user', 'tanggal_saran', 'teks_saran', 'bintang', 'status_tampil'];
    public $timestamps = false;
}
