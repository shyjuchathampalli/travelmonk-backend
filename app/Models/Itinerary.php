<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_request_id',
        'package_id',
        'day_number',
        'destination_id',
        'stay_option',
        'vehicle_option',
        'stay_vendor_id',
        'transport_vendor_id',
        'margin',
        'offer',
        'status',
    ];

    public function tripRequest()
    {
        return $this->belongsTo(TripRequest::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
