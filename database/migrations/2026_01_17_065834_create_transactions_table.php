<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trip_request_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('reference_type', [
                'trip',
                'itinerary',
                'activity'
            ]);

            $table->unsignedBigInteger('reference_id');

            $table->decimal('amount', 10, 2);
            $table->string('currency', 5)->default('INR');

            $table->enum('payment_mode', [
                'online',
                'upi',
                'card',
                'bank_transfer',
                'cash'
            ]);

            $table->enum('payment_status', [
                'initiated',
                'success',
                'failed',
                'refunded'
            ])->default('initiated');

            $table->string('transaction_ref')->nullable();
            $table->json('gateway_response')->nullable();

            $table->timestamps();

            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
