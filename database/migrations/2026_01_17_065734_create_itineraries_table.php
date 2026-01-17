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
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trip_request_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('package_id')
                  ->nullable()
                  ->constrained('packages')
                  ->nullOnDelete();

            $table->unsignedInteger('day_number');

            $table->foreignId('destination_id')
                  ->constrained('destinations')
                  ->restrictOnDelete();

            $table->string('stay_option')->nullable();
            $table->string('vehicle_option')->nullable();

            $table->foreignId('stay_vendor_id')
                  ->nullable()
                  ->constrained('vendors')
                  ->nullOnDelete();

            $table->foreignId('transport_vendor_id')
                  ->nullable()
                  ->constrained('vendors')
                  ->nullOnDelete();

            $table->decimal('margin', 8, 2)->default(0);
            $table->decimal('offer', 8, 2)->default(0);

            $table->enum('status', ['confirmed', 'rejected', 'pending'])
                  ->default('pending');

            $table->timestamps();

            $table->index(['trip_request_id', 'day_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};
