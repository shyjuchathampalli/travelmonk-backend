<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'destination_category_id',
        'business_name',
        'image',
        'contact_name',
        'email',
        'phone',
        'price_range',
        'details',
        'caption',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function destinationCategory()
    {
        return $this->belongsTo(DestinationCategory::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
