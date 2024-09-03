<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'user_id',
        'shop_id',
        'title',
        'review',
        'rating',
    ];

    public function booking() {
    return $this->belongsTo(Booking::class);
    }

}
