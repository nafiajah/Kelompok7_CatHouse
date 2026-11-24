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

    public function getGenderAttribute(): ?string
    {
        if (empty($this->deskripsi)) {
            return null;
        }

        if (preg_match('/\bjantan\b/i', $this->deskripsi)) {
            return 'Jantan';
        }

        if (preg_match('/\bbetina\b/i', $this->deskripsi)) {
            return 'Betina';
        }

        return null;
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            $filename = basename($this->foto);

            // 1. Check direct upload path
            if (file_exists(public_path('uploads/cats/' . $filename))) {
                return asset('uploads/cats/' . $filename);
            }

            // 2. Check public/images/cats/
            if (file_exists(public_path('images/cats/' . $filename))) {
                return asset('images/cats/' . $filename);
            }

            // 3. Check public/images/
            if (file_exists(public_path('images/' . $filename))) {
                return asset('images/' . $filename);
            }

            // 4. Check public/images/cat-{filename}
            if (file_exists(public_path('images/cat-' . $filename))) {
                return asset('images/cat-' . $filename);
            }
        }

        // 5. Match by cat name slug in images/cats/ or images/
        if ($this->nama_kucing) {
            $slug = Str::slug($this->nama_kucing);
            foreach (['png', 'jpg', 'jpeg', 'webp'] as $extension) {
                if (file_exists(public_path("images/cats/{$slug}.{$extension}"))) {
                    return asset("images/cats/{$slug}.{$extension}");
                }
                if (file_exists(public_path("images/cat-{$slug}.{$extension}"))) {
                    return asset("images/cat-{$slug}.{$extension}");
                }
                if (file_exists(public_path("images/{$slug}.{$extension}"))) {
                    return asset("images/{$slug}.{$extension}");
                }
            }
        }

        // 6. External URL check
        if ($this->foto) {
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                return $this->foto;
            }

            if (file_exists(public_path('storage/' . $this->foto))) {
                return asset('storage/' . $this->foto);
            }
        }

        return asset('images/cat-photo.png');
    }
}
