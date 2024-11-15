<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'content',
        'rating',
        'image',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
