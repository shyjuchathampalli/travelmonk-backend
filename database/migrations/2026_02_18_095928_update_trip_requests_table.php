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
        Schema::table('trip_requests', function (Blueprint $table) {

            // Public unique reference (for URLs & external access)
            $table->string('reference_code', 20)
                  ->unique()
                  ->after('id');

            // Link TripRequest to Package (VERY IMPORTANT)
            $table->foreignId('package_id')
                  ->after('user_id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_requests', function (Blueprint $table) {

            $table->dropColumn('reference_code');

            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
};
