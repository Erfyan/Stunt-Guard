<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained('balitas')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('umur_bulan');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('lingkar_kepala', 5, 2)->nullable();
            $table->decimal('lingkar_lengan', 5, 2)->nullable();
            $table->string('cara_ukur', 50)->nullable();
            $table->decimal('zscore', 5, 2)->nullable();
            $table->string('status_gizi', 50)->nullable();
            $table->string('status_stunting', 50)->nullable();
            $table->enum('bb_tidak_nak', ['Ya', 'Tidak'])->nullable();
            $table->text('catatan')->nullable();
            // Kolom 'created_by' dan 'petugas' akan ditambahkan di migrasi terpisah
            // agar tidak bentrok dengan migrasi add_created_by...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};