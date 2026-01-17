<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_request_id',
        'reference_type',
        'reference_id',
        'amount',
        'currency',
        'payment_mode',
        'payment_status',
        'transaction_ref',
        'gateway_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
    ];

    /**
     * Relationships
     */
    public function tripRequest()
    {
        return $this->belongsTo(TripRequest::class);
    }
}
