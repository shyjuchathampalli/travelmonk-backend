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
        Schema::create('package_arrival_point', function (Blueprint $table) {
            $table->id();

            $table->foreignId('package_id')
                  ->constrained('packages')
                  ->cascadeOnDelete();

            $table->foreignId('arrival_point_id')
                  ->constrained('arrival_points')
                  ->cascadeOnDelete();

            $table->unique(
                ['package_id', 'arrival_point_id'],
                'pkg_arrival_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_arrival_point');
    }
};
