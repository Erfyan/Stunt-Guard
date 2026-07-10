<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('pelayanan_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->enum('asi_eksklusif', ['Ya', 'Tidak'])->nullable();
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaans')->onDelete('cascade');
            $table->string('vitamin_a', 50)->nullable();
            $table->string('obat_cacing', 50)->nullable();
            $table->enum('mt_pemulihan', ['Ya', 'Tidak'])->nullable();
            $table->enum('penyuluhan', ['Ya', 'Tidak'])->nullable();
            $table->string('topik_penyuluhan', 255)->nullable();
            $table->string('rujukan', 255)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('pelayanan_kesehatans');
    }
};