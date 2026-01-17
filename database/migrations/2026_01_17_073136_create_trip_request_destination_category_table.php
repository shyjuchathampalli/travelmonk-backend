<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_request_destination_category', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('trip_request_id');
            $table->unsignedBigInteger('destination_category_id');

            // Foreign keys with SHORT names
            $table->foreign('trip_request_id', 'trdc_trip_fk')
                  ->references('id')
                  ->on('trip_requests')
                  ->cascadeOnDelete();

            $table->foreign('destination_category_id', 'trdc_cat_fk')
                  ->references('id')
                  ->on('destination_categories')
                  ->cascadeOnDelete();

            // Short unique index
            $table->unique(
                ['trip_request_id', 'destination_category_id'],
                'trip_dest_cat_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_request_destination_category');
    }
};
