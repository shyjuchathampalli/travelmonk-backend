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
        Schema::create('trip_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->date('arrival_date');
            $table->date('end_date');
            $table->unsignedInteger('number_of_days');

            $table->foreignId('arrival_point_id')
                  ->constrained('arrival_points')
                  ->restrictOnDelete();

            $table->unsignedInteger('adults')->default(1);
            $table->unsignedInteger('children')->default(0);

            $table->string('stay_option')->nullable();       // hotel, resort, homestay
            $table->string('transport_option')->nullable(); // cab, self-drive, bus

            $table->enum('status', [
                'in_progress',
                'paused',
                'postponed',
                'abandoned',
                'priced',
                'paid',
                'confirmed',
                'active_trip',
                'completed'
            ])->default('in_progress');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_requests');
    }
};
