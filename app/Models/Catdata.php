<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catdata extends Model
{
    protected $fillable = ['id_jenis_kucings', 'nama_kucing', 'deskripsi', 'foto'];
    public $timestamps = false;

}
