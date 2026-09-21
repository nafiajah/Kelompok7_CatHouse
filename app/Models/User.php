<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['role', 'username', 'password', 'nama_pelanggan', 'no_telp', 'email'];
    public $timestamps = false;

}
