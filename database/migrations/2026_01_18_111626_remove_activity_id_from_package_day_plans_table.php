<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_day_plans', function (Blueprint $table) {
            // Drop FK only if it exists
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('package_day_plans');

            if ($doctrineTable->hasForeignKey('package_day_plans_activity_id_foreign')) {
                $table->dropForeign('package_day_plans_activity_id_foreign');
            }

            if (Schema::hasColumn('package_day_plans', 'activity_id')) {
                $table->dropColumn('activity_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('package_day_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_id')->nullable();

            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
                ->nullOnDelete();
        });
    }
};
