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
        Schema::table('package_day_plans', function (Blueprint $table) {
            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('package_day_plans', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
        });
    }
};
