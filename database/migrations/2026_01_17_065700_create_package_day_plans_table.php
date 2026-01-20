<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_day_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('package_id')
                ->constrained('packages')
                ->cascadeOnDelete();

            $table->unsignedInteger('day_number');

            $table->foreignId('destination_id')
                ->constrained('destinations')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('activity_id')->nullable();

            $table->unsignedInteger('sequence')->default(1);
            $table->timestamps();

            $table->index(['package_id', 'day_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_day_plans');
    }
};
