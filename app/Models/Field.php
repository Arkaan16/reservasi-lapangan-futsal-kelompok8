<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    // Field yang bisa diisi oleh user
    protected $fillable = ['name', 'price_per_hour', 'description'];

    // Relasi dengan tabel bookings, jika ada pemesanan terkait lapangan ini
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}