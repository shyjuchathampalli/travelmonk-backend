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
        if (!Schema::hasTable('package_day_plan_activity')) {
            Schema::create('package_day_plan_activity', function (Blueprint $table) {
                $table->id();

                $table->foreignId('package_day_plan_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('activity_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->unsignedInteger('sequence')
                    ->default(1);

                $table->timestamps();

                // Prevent duplicate activity assignment per day
                $table->unique(
                    ['package_day_plan_id', 'activity_id'],
                    'pdp_activity_unique'
                );
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_day_plan_activity');
    }
};
