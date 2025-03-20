<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'package_id',
        'schedule_id',
        'customer_address_id',
        'number_of_people',
        'total_amount',
        'status',
        'booking_date',
        'special_requirements'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_number = 'MT-' . time() . rand(1000, 9999);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddress::class);
    }
}
