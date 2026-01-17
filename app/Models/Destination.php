<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'arrival_point_id',
        'name',
        'description',
        'latitude',
        'longitude',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function arrivalPoint()
    {
        return $this->belongsTo(ArrivalPoint::class);
    }

    public function categories()
    {
        return $this->belongsToMany(
            DestinationCategory::class,
            'destination_category'
        );
    }
}
