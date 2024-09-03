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
        'number',
    ];

    public function review() {
        return $this->hasOne(Review::class);
    }

}
