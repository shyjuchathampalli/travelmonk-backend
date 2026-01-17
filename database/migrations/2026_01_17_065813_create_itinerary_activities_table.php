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
        Schema::create('itinerary_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trip_request_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('itinerary_id')
                  ->constrained('itineraries')
                  ->cascadeOnDelete();

            $table->foreignId('activity_id')
                  ->constrained('activities')
                  ->restrictOnDelete();

            $table->foreignId('vendor_id')
                  ->nullable()
                  ->constrained('vendors')
                  ->nullOnDelete();

            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('margin', 8, 2)->default(0);
            $table->decimal('offer', 8, 2)->default(0);

            $table->enum('status', ['pending', 'confirmed', 'rejected'])
                  ->default('pending');

            $table->timestamps();

            $table->index(['trip_request_id', 'itinerary_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerary_activities');
    }
};
