<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'number_of_days',
        'base_price',
        'package_image',
        'route_map_image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function destinations()
    {
        return $this->belongsToMany(
            Destination::class,
            'package_destination'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            DestinationCategory::class,
            'package_category'
        );
    }

    public function arrivalPoints()
    {
        return $this->belongsToMany(
            ArrivalPoint::class,
            'package_arrival_point'
        );
    }

    public function dayPlans()
    {
        return $this->hasMany(PackageDayPlan::class)
                    ->orderBy('day_number')
                    ->orderBy('sequence');
    }
}
