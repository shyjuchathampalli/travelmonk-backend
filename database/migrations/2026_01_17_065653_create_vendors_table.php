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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('destination_id')
                  ->nullable()
                  ->constrained('destinations')
                  ->nullOnDelete();

            $table->foreignId('destination_category_id')
                  ->nullable()
                  ->constrained('destination_categories')
                  ->nullOnDelete();

            $table->string('business_name');
            $table->string('contact_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();

            $table->string('price_range')->nullable(); // e.g. Budget / Mid / Premium
            $table->text('details')->nullable();
            $table->string('caption')->nullable();

            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['destination_id', 'destination_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
