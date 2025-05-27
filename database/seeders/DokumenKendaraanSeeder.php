<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use App\Models\DokumenKendaraan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DokumenKendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua kendaraan
        $kendaraans = Kendaraan::all();

        foreach ($kendaraans as $kendaraan) {
            // Buat STNK
            DokumenKendaraan::create([
                'kendaraan_id' => $kendaraan->id,
                'jenis_dokumen' => 'STNK',
                'nomor_dokumen' => 'STNK-' . strtoupper(substr(str_replace(' ', '', $kendaraan->nomor_polisi), 0, 8)),
                'tanggal_terbit' => Carbon::now()->subMonths(rand(1, 6)),
                'tanggal_expired' => Carbon::now()->addYear(),
                'keterangan' => 'STNK untuk kendaraan ' . $kendaraan->merek . ' ' . $kendaraan->model
            ]);

            // Buat BPKB
            DokumenKendaraan::create([
                'kendaraan_id' => $kendaraan->id,
                'jenis_dokumen' => 'BPKB',
                'nomor_dokumen' => 'BPKB-' . strtoupper(substr(str_replace(' ', '', $kendaraan->nomor_rangka), -8)),
                'tanggal_terbit' => Carbon::now()->subMonths(rand(1, 6)),
                'keterangan' => 'BPKB untuk kendaraan ' . $kendaraan->merek . ' ' . $kendaraan->model
            ]);

            // Buat Faktur
            DokumenKendaraan::create([
                'kendaraan_id' => $kendaraan->id,
                'jenis_dokumen' => 'Faktur',
                'nomor_dokumen' => 'FK-' . strtoupper(substr(str_replace(' ', '', $kendaraan->nomor_mesin), -8)),
                'tanggal_terbit' => Carbon::now()->subMonths(rand(1, 6)),
                'keterangan' => 'Faktur untuk kendaraan ' . $kendaraan->merek . ' ' . $kendaraan->model
            ]);
        }
    }
}
