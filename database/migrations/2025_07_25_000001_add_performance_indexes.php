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
        Schema::table('kendaraans', function (Blueprint $table) {
            // Add indexes for frequently queried columns
            $table->index('status', 'idx_kendaraans_status');
            $table->index('merek', 'idx_kendaraans_merek');
            $table->index('tahun_pembuatan', 'idx_kendaraans_tahun');
            $table->index('harga_jual', 'idx_kendaraans_harga_jual');
            $table->index(['status', 'harga_jual'], 'idx_kendaraans_status_harga');
            $table->index(['status', 'merek'], 'idx_kendaraans_status_merek');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('type', 'idx_categories_type');
        });

        Schema::table('kendaraan_category', function (Blueprint $table) {
            // Composite index for junction table
            $table->index(['kendaraan_id', 'category_id'], 'idx_kendaraan_category_composite');
        });

        Schema::table('dokumen_kendaraans', function (Blueprint $table) {
            $table->index('jenis_dokumen', 'idx_dokumen_jenis');
            $table->index('tanggal_expired', 'idx_dokumen_expired');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->dropIndex('idx_kendaraans_status');
            $table->dropIndex('idx_kendaraans_merek');
            $table->dropIndex('idx_kendaraans_tahun');
            $table->dropIndex('idx_kendaraans_harga_jual');
            $table->dropIndex('idx_kendaraans_status_harga');
            $table->dropIndex('idx_kendaraans_status_merek');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_type');
        });

        Schema::table('kendaraan_category', function (Blueprint $table) {
            $table->dropIndex('idx_kendaraan_category_composite');
        });

        Schema::table('dokumen_kendaraans', function (Blueprint $table) {
            $table->dropIndex('idx_dokumen_jenis');
            $table->dropIndex('idx_dokumen_expired');
        });
    }
};
