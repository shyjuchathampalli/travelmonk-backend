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
        Schema::table('activities', function (Blueprint $table) {
            // Make vendor_id nullable
            $table->foreignId('vendor_id')
                ->nullable()
                ->change();

            // Make base_price nullable
            $table->decimal('base_price', 10, 2)
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            // Revert vendor_id to NOT NULL
            $table->foreignId('vendor_id')
                ->nullable(false)
                ->change();

            // Revert base_price to NOT NULL with default
            $table->decimal('base_price', 10, 2)
                ->default(0)
                ->nullable(false)
                ->change();
        });
    }
};
