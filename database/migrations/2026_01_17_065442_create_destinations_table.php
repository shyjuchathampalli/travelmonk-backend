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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')
                  ->constrained('states')
                  ->cascadeOnDelete();
            $table->foreignId('arrival_point_id')
                  ->nullable()
                  ->constrained('arrival_points')
                  ->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->unique(['state_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
