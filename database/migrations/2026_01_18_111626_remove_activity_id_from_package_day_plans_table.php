<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column exists before touching it
        if (Schema::hasColumn('package_day_plans', 'activity_id')) {

            // Drop FK only if it exists
            DB::statement("
                ALTER TABLE package_day_plans
                DROP FOREIGN KEY IF EXISTS package_day_plans_activity_id_foreign
            ");

            Schema::table('package_day_plans', function (Blueprint $table) {
                $table->dropColumn('activity_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('package_day_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('package_day_plans', 'activity_id')) {
                $table->unsignedBigInteger('activity_id')->nullable()->after('destination_id');
            }
        });

        DB::statement("
            ALTER TABLE package_day_plans
            ADD CONSTRAINT package_day_plans_activity_id_foreign
            FOREIGN KEY (activity_id) REFERENCES activities(id)
            ON DELETE SET NULL
        ");
    }
};
