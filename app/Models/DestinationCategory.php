<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function destinations()
    {
        return $this->belongsToMany(
            Destination::class,
            'destination_category'
        );
    }
}
