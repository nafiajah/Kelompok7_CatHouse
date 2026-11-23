<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $table = 'variants';

    public $timestamps = false;

    protected $fillable = ['jenis'];

    public function dataKucing()
    {
        return $this->hasMany(DataKucing::class, 'id_variant');
    }

    public function cats()
    {
        return $this->hasMany(DataKucing::class, 'id_variant');
    }
}
