<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
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
