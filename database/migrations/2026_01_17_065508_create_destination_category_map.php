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
        Schema::create('destination_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')
                  ->constrained('destinations')
                  ->cascadeOnDelete();
            $table->foreignId('destination_category_id')
                  ->constrained('destination_categories')
                  ->cascadeOnDelete();

            $table->unique(
                ['destination_id', 'destination_category_id'],
                'dest_cat_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destination_category');
    }
};
