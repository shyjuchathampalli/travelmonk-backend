<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDayPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'day_number',
        'destination_id',
        'description',
    ];

    /**
     * Relationships
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function activities()
    {
        return $this->belongsToMany(
            Activity::class,
            'package_day_plan_activity'
        )
            ->withPivot('sequence')
            ->orderBy('package_day_plan_activity.sequence');
    }
}
