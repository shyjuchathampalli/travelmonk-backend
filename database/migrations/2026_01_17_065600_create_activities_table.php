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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('destination_id')
                  ->nullable()
                  ->constrained('destinations')
                  ->nullOnDelete();

            $table->foreignId('vendor_id')
                  ->constrained('vendors')
                  ->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            $table->decimal('base_price', 10, 2)->default(0);

            $table->enum('type', ['destination', 'general'])
                  ->default('destination');

            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['destination_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
