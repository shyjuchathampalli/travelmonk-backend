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
        Schema::create('arrival_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')
                  ->constrained('states')
                  ->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['airport', 'railway', 'bus', 'seaport'])->default('airport');
            $table->string('code', 10)->nullable(); // Airport/Rail code
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->unique(['state_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arrival_points');
    }
};
