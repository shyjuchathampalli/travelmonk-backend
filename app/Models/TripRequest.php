<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TripRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_code',
        'user_id',
        'package_id',
        'arrival_date',
        'end_date',
        'number_of_days',
        'arrival_point_id',
        'adults',
        'children',
        'stay_option',
        'transport_option',
        'status',
        'final_price',
    ];

    protected $casts = [
    'arrival_date' => 'date:Y-m-d',
    'end_date' => 'date:Y-m-d',
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

    public function childrenDetails()
    {
        return $this->hasMany(TripRequestChild::class);
    }

    public function arrivalPoint()
    {
        return $this->belongsTo(ArrivalPoint::class);
    }

    public function package()
    {
        return $this->belongsTo(\App\Models\Package::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trip) {
            $trip->reference_code = strtoupper(Str::random(20));
        });
    }
}
