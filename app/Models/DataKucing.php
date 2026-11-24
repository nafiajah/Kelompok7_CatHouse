<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        if ($this->foto) {
            $filename = basename($this->foto);
            $uploadPath = 'uploads/cats/' . $filename;
            if (file_exists(public_path($uploadPath))) {
                return asset($uploadPath);
            }
        }

        if ($this->nama_kucing) {
            foreach (['png', 'jpg', 'jpeg', 'webp'] as $extension) {
                $namedPhotoPath = 'images/cats/' . Str::slug($this->nama_kucing) . '.' . $extension;
                if (file_exists(public_path($namedPhotoPath))) {
                    return asset($namedPhotoPath);
                }
            }
        }

        if ($this->foto) {
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                return $this->foto;
            }

            $storagePath = 'storage/' . $this->foto;
            if (file_exists(public_path($storagePath))) {
                return asset($storagePath);
            }

            $namedPhotoPath = 'images/cat-' . pathinfo($filename, PATHINFO_FILENAME) . '.jpg';
            if (file_exists(public_path($namedPhotoPath))) {
                return asset($namedPhotoPath);
            }
        }

        return asset('images/cat-photo.png');
    }
}
