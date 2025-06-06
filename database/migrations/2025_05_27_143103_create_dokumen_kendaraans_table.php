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
        Schema::create('dokumen_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraans')->onDelete('cascade');
            $table->string('jenis_dokumen'); // STNK, BPKB, Faktur, dll
            $table->string('nomor_dokumen');
            $table->date('tanggal_terbit');
            $table->date('tanggal_expired')->nullable();
            $table->string('file_path')->nullable(); // untuk menyimpan path file dokumen yang diupload
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_kendaraans');
    }
};
