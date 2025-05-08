<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'user_type_id',  // Points to roles table
        'user_status_id', // Points to user_statuses table
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_type_id' => 'integer',
        'user_status_id' => 'integer',
    ];

    // Relationship to Role (previously called user_type)
    public function role()
    {
        return $this->belongsTo(Role::class, 'user_type_id');
    }

    // Relationship to UserStatus
    public function status()
    {
        return $this->belongsTo(UserStatus::class, 'user_status_id');
    }
}