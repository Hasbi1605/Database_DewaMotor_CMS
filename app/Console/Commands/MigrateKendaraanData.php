<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kendaraan;

class MigrateKendaraanData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:kendaraan-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Kendaraan data from Seeder to Oracle database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
            [
                'nomor_rangka' => 'R123456',
                'nomor_mesin' => 'M123456',
                'nomor_polisi' => 'B1234CD',
                'merek' => 'Yamaha',
                'model' => 'Nmax',
                'tahun_pembuatan' => 2020,
                'harga_modal' => 20000000,
                'harga_jual' => 22000000,
            ],
            [
                'nomor_rangka' => 'R654321',
                'nomor_mesin' => 'M654321',
                'nomor_polisi' => 'B5678EF',
                'merek' => 'Honda',
                'model' => 'Pcx',
                'tahun_pembuatan' => 2021,
                'harga_modal' => 18000000,
                'harga_jual' => 20000000,
            ],
            // Add more data as needed from KendaraanSeeder
        ];

        foreach ($data as $item) {
            Kendaraan::create($item);
        }

        $this->info('Kendaraan data has been migrated successfully.');

        return 0;
    }
}
