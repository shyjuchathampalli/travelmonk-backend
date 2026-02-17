<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        // Generate unique slugs
        $packages = DB::table('packages')->get();

        foreach ($packages as $package) {
            $baseSlug = Str::slug($package->name);
            $slug = $baseSlug;
            $counter = 1;

            while (DB::table('packages')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            DB::table('packages')
                ->where('id', $package->id)
                ->update(['slug' => $slug]);
        }

        // Now make it unique
        Schema::table('packages', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
