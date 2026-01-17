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
        Schema::create('trip_request_travel_purpose', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trip_request_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('travel_purpose_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Short index name (IMPORTANT)
            $table->unique(
                ['trip_request_id', 'travel_purpose_id'],
                'trip_purpose_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_request_travel_purpose');
    }
};
