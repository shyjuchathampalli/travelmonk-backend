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
            if (!Schema::hasColumn('package_day_plans', 'description')) {
                $table->text('description')
                    ->nullable()
                    ->after('destination_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_day_plans', function (Blueprint $table) {
            if (Schema::hasColumn('package_day_plans', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
