<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            if (!Schema::hasColumn('pemeriksaans', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('catatan')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('pemeriksaans', 'petugas')) {
                $table->string('petugas', 100)->nullable()->after('created_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            if (Schema::hasColumn('pemeriksaans', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('pemeriksaans', 'petugas')) {
                $table->dropColumn('petugas');
            }
        });
    }
};