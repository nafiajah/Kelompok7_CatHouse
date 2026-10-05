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
    public $incrementing = false;

    protected $fillable = [
        'id',
        'role',
        'username',
        'password',
        'nama_pelanggan',
        'email',
        'no_telp',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (static::max('id') ?? 0) + 1;
            }
        });
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_users');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_user');
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
