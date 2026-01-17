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
        Schema::create('trip_request_general_activity', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trip_request_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('activity_id')
                ->constrained('activities')
                ->cascadeOnDelete();

            $table->unique(
                ['trip_request_id', 'activity_id'],
                'trip_gen_activity_unique'
            );
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_request_general_activity');
    }
};
