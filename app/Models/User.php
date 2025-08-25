<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ADD THIS IMPORT
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // ADD HasFactory HERE

    protected $fillable = ['name','email','password','role','status'];
    protected $hidden = ['password','remember_token'];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function member(): HasOne { 
        return $this->hasOne(Member::class); 
    }

    public function isAdmin(): bool { 
        return $this->role === 'admin'; 
    }
}