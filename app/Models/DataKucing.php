<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKucing extends Model
{
    protected $table = 'data_kucing';

    public $timestamps = false;

    protected $fillable = [
        'id_variant',
        'nama_kucing',
        'deskripsi',
        'foto',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'id_variant');
    }

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=600&auto=format&fit=crop&q=80';
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        if (file_exists(public_path('uploads/cats/' . $this->foto))) {
            return asset('uploads/cats/' . $this->foto);
        }

        return asset('storage/' . $this->foto);
    }
}
