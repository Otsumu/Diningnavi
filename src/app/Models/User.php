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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function favorites() {
    return $this->belongsToMany(Shop::class, 'favorites', 'user_id', 'shop_id');
    }

    public function shops() {
        return $this->hasMany(Shop::class,'user_id');
    }

    public function scopeAdmin($query) {
        return $query->where('role', 'admin');
    }

    public function scopeShopOwner($query) {
        return $query->where('role', 'shop_owner');
    }

    public function scopeRegularUser($query) {
        return $query->where('role', 'user');
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isShopOwner() {
        return $this->role === 'shop_owner';
    }

    public function isRegularUser() {
        return $this->role === 'user';
    }

}
