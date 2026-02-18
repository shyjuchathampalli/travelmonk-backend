<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRequestChild extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_request_id',
        'age',
    ];

    /**
     * Relationships
     */
    public function tripRequest()
    {
        return $this->belongsTo(TripRequest::class);
    }
}
