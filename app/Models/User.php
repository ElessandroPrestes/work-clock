<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'password',
        'role',
        'position',
        'birthdate',
        'manager_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthdate' => 'date',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!\Illuminate\Support\Str::startsWith($user->password, '$2y$')) {
                $user->password = bcrypt($user->password);
            }
        });
    }

    public function timeRecords()
    {
        return $this->hasMany(ClockRecord::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEmployee()
    {
        return $this->role === 'employee';
    }
}
