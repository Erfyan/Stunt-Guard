<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ibuses', function (Blueprint $table) {
            $table->id(); // id_ibu
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique(); // one-to-one
            $table->string('nik', 20)->unique();
            $table->string('nama_ibu');
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ibuses');
    }
};