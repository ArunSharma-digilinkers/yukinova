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
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ✅ ADD THIS (User has many addresses)
    public function addresses()
    {
        return $this->hasMany(\App\Models\Address::class);
    }

    // ✅ ADD THIS (User has one default address)
    public function defaultAddress()
    {
        return $this->hasOne(\App\Models\Address::class)
                    ->where('is_default', 1);
    }
}