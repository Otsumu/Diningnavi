<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'booking_date',
        'booking_time',
        'number',
    ];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function review() {
        return $this->hasOne(Review::class);
    }

    public function comments() {
        return $this->hasOne(Comment::class);
    }

}
