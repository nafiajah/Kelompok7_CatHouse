<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = ['jam_sesi', 'token_sesi'];
    public $timestamps = false;

}
