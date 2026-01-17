<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'arrival_date',
        'end_date',
        'number_of_days',
        'arrival_point_id',
        'adults',
        'children',
        'stay_option',
        'transport_option',
        'status',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function travelPurposes()
    {
        return $this->belongsToMany(
            TravelPurpose::class,
            'trip_request_travel_purpose'
        );
    }

    public function destinationCategories()
    {
        return $this->belongsToMany(
            DestinationCategory::class,
            'trip_request_destination_category'
        );
    }

    public function generalActivities()
    {
        return $this->belongsToMany(
            Activity::class,
            'trip_request_general_activity'
        )->where('type', 'general');
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }
}
