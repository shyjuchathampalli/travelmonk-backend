<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrivalPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'name',
        'type',
        'code',
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
}
