<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'vendor_id',
        'name',
        'description',
        'base_price',
        'type',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
