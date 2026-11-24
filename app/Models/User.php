<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = null;
    protected static ?string $resolvedTable = null;

    public function getTable()
    {
        if ($this->table !== null) {
            return $this->table;
        }

        if (static::$resolvedTable === null) {
            try {
                if (Schema::hasTable('members')) {
                    static::$resolvedTable = 'members';
                } elseif (Schema::hasTable('users')) {
                    static::$resolvedTable = 'users';
                } else {
                    static::$resolvedTable = 'members';
                }
            } catch (\Throwable $e) {
                static::$resolvedTable = 'members';
            }
        }

        return static::$resolvedTable;
    }

    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id',
        'role',
        'username',
        'password',
        'nama_lengkap',
        'email',
        'alamat',
        'no_telp',
    ];

    public function getNamaLengkapAttribute()
    {
        return $this->attributes['nama_lengkap'] ?? ($this->attributes['username'] ?? 'User');
    }

    public function getNamaPelangganAttribute()
    {
        return $this->attributes['nama_lengkap'] ?? ($this->attributes['nama_pelanggan'] ?? ($this->attributes['username'] ?? null));
    }

    public function setNamaPelangganAttribute($value)
    {
        $this->attributes['nama_lengkap'] = $value;
    }

    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Keep safe fallback only if id is not automatically assigned
            if (empty($model->id) && $model->incrementing === false) {
                $model->id = (static::max('id') ?? 0) + 1;
            }
        });
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_users');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'id_user');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
