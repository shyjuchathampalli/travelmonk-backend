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
        Schema::create('package_category', function (Blueprint $table) {
            $table->id();

            $table->foreignId('package_id')
                  ->constrained('packages')
                  ->cascadeOnDelete();

            $table->foreignId('destination_category_id')
                  ->constrained('destination_categories')
                  ->cascadeOnDelete();

            $table->unique(
                ['package_id', 'destination_category_id'],
                'pkg_cat_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_category');
    }
};
