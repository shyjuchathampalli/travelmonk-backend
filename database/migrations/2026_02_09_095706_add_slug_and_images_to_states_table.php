<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('states', function (Blueprint $table) {
        $table->string('slug')->nullable()->after('name');
        $table->string('banner_image')->nullable();
        $table->string('thumbnail_image')->nullable();
    });

    // Backfill slugs for existing states
    DB::table('states')->whereNull('slug')->orWhere('slug', '')
        ->update([
            'slug' => DB::raw("LOWER(REPLACE(name, ' ', '-'))")
        ]);

    Schema::table('states', function (Blueprint $table) {
        $table->unique(['country_id', 'slug'], 'states_country_id_slug_unique');
    });
}

    public function down(): void
    {
        Schema::table('states', function (Blueprint $table) {
            $table->dropUnique(['country_id', 'slug']);
            $table->dropColumn([
                'slug',
                'banner_image',
                'thumbnail_image',
            ]);
        });
    }
};
