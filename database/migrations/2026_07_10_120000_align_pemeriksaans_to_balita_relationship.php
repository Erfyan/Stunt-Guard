<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pemeriksaans', 'balita_id')) {
            Schema::table('pemeriksaans', function (Blueprint $table) {
                $table->foreignId('balita_id')->nullable()->after('id')->constrained('balitas')->onDelete('cascade');
            });
        }

        if (Schema::hasColumn('pemeriksaans', 'pemeriksaan_id')) {
            Schema::table('pemeriksaans', function (Blueprint $table) {
                $table->dropForeign(['pemeriksaan_id']);
            });

            Schema::table('pemeriksaans', function (Blueprint $table) {
                $table->dropColumn('pemeriksaan_id');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('pemeriksaans', 'pemeriksaan_id')) {
            Schema::table('pemeriksaans', function (Blueprint $table) {
                $table->foreignId('pemeriksaan_id')->nullable()->after('id')->constrained('pemeriksaans')->onDelete('cascade');
            });
        }

        if (Schema::hasColumn('pemeriksaans', 'balita_id')) {
            Schema::table('pemeriksaans', function (Blueprint $table) {
                $table->dropForeign(['balita_id']);
                $table->dropColumn('balita_id');
            });
        }
    }
};
