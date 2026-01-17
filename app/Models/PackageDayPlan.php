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
        'activity_id',
        'sequence',
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

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
