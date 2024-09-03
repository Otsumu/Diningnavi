<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'intro',
        'genre_id',
        'area_id',
    ];

    public function genre() {
        return $this->belongsTo(Genre::class);
    }

    public function area() {
        return $this->belongsTo(Area::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function scopeGenre($query, $genreId) {
        if ($genreId) {
            return $query->where('genre_id', $genreId);
        }
        return $query;
    }

    public function scopeArea($query, $areaId) {
        if ($areaId) {
            return $query->where('area_id', $areaId);
        }
        return $query;
    }

    public function scopeKeyword($query, $keyword) {
        if ($keyword) {
            return $query->where('name', 'like', "%{$keyword}%");
        }
        return $query;
    }

}
