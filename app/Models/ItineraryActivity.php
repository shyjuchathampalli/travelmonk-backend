<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItineraryActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_request_id',
        'itinerary_id',
        'activity_id',
        'vendor_id',
        'price',
        'margin',
        'offer',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'margin' => 'decimal:2',
        'offer' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function tripRequest()
    {
        return $this->belongsTo(TripRequest::class);
    }

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
