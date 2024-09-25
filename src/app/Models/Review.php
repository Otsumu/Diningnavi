<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'booking_id',
        'title',
        'review',
        'rating',
    ];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }
}
