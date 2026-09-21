<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['metode_pembayaran','total_harga','tanggal_pembayaran'];
    public $timestamps = false;

}
