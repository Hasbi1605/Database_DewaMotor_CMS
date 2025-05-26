<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kendaraan;

class KendaraanSeeder extends Seeder
{
    public function run()
    {
        $motorData = [
            [
                'nomor_rangka' => 'MH1KC2229PK123456',
                'nomor_mesin' => 'KC22E1123456',
                'nomor_polisi' => 'B1234KCM',
                'merek' => 'Honda',
                'model' => 'Vario 160',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 25000000,
                'harga_jual' => 27500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1RE2229PK234567',
                'nomor_mesin' => 'RE22E1234567',
                'nomor_polisi' => 'B5678KCM',
                'merek' => 'Honda',
                'model' => 'PCX 160',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 32000000,
                'harga_jual' => 34500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1BD2229PK345678',
                'nomor_mesin' => 'BD22E1345678',
                'nomor_polisi' => 'B9012KCM',
                'merek' => 'Honda',
                'model' => 'Beat',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 18000000,
                'harga_jual' => 19500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1SC2229PK456789',
                'nomor_mesin' => 'SC22E1456789',
                'nomor_polisi' => 'B3456KCM',
                'merek' => 'Honda',
                'model' => 'Scoopy',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 21000000,
                'harga_jual' => 22500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1NM2229PK567890',
                'nomor_mesin' => 'NM22E1567890',
                'nomor_polisi' => 'B7890KCM',
                'merek' => 'Yamaha',
                'model' => 'NMAX',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 35000000,
                'harga_jual' => 37500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1AR2229PK678901',
                'nomor_mesin' => 'AR22E1678901',
                'nomor_polisi' => 'B1234KDM',
                'merek' => 'Yamaha',
                'model' => 'Aerox',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 28000000,
                'harga_jual' => 30000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1MT2229PK789012',
                'nomor_mesin' => 'MT22E1789012',
                'nomor_polisi' => 'B5678KDM',
                'merek' => 'Yamaha',
                'model' => 'Mio',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 19000000,
                'harga_jual' => 20500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1FZ2229PK890123',
                'nomor_mesin' => 'FZ22E1890123',
                'nomor_polisi' => 'B9012KDM',
                'merek' => 'Yamaha',
                'model' => 'Fazzio',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 22000000,
                'harga_jual' => 23500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'ML1VE2229PK901234',
                'nomor_mesin' => 'VE22E1901234',
                'nomor_polisi' => 'B3456KDM',
                'merek' => 'Vespa',
                'model' => 'Sprint',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 55000000,
                'harga_jual' => 58000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'ML1PM2229PK012345',
                'nomor_mesin' => 'PM22E1012345',
                'nomor_polisi' => 'B7890KDM',
                'merek' => 'Vespa',
                'model' => 'Primavera',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 52000000,
                'harga_jual' => 55000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1KC2229PK123457',
                'nomor_mesin' => 'KC22E1123457',
                'nomor_polisi' => 'B1234KEM',
                'merek' => 'Honda',
                'model' => 'Vario 125',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 23000000,
                'harga_jual' => 25000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1AD2229PK234568',
                'nomor_mesin' => 'AD22E1234568',
                'nomor_polisi' => 'B5678KEM',
                'merek' => 'Honda',
                'model' => 'ADV 160',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 36000000,
                'harga_jual' => 38500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1CB2229PK345679',
                'nomor_mesin' => 'CB22E1345679',
                'nomor_polisi' => 'B9012KEM',
                'merek' => 'Honda',
                'model' => 'CBR 150R',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 38000000,
                'harga_jual' => 40500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1RR2229PK456790',
                'nomor_mesin' => 'RR22E1456790',
                'nomor_polisi' => 'B3456KEM',
                'merek' => 'Yamaha',
                'model' => 'R15',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 39000000,
                'harga_jual' => 41500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1MT2229PK567891',
                'nomor_mesin' => 'MT22E1567891',
                'nomor_polisi' => 'B7890KEM',
                'merek' => 'Yamaha',
                'model' => 'MT-15',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 37000000,
                'harga_jual' => 39500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1XM2229PK678902',
                'nomor_mesin' => 'XM22E1678902',
                'nomor_polisi' => 'B1234KFM',
                'merek' => 'Yamaha',
                'model' => 'XMax',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 65000000,
                'harga_jual' => 68000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1GT2229PK789013',
                'nomor_mesin' => 'GT22E1789013',
                'nomor_polisi' => 'B5678KFM',
                'merek' => 'Honda',
                'model' => 'GTR 150',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 28000000,
                'harga_jual' => 30000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1SP2229PK890124',
                'nomor_mesin' => 'SP22E1890124',
                'nomor_polisi' => 'B9012KFM',
                'merek' => 'Honda',
                'model' => 'Spacy',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 19000000,
                'harga_jual' => 20500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1GF2229PK901235',
                'nomor_mesin' => 'GF22E1901235',
                'nomor_polisi' => 'B3456KFM',
                'merek' => 'Yamaha',
                'model' => 'Grand Filano',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 25000000,
                'harga_jual' => 27000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'ML1GS2229PK012346',
                'nomor_mesin' => 'GS22E1012346',
                'nomor_polisi' => 'B7890KFM',
                'merek' => 'Vespa',
                'model' => 'GTS',
                'tahun_pembuatan' => 2023,
                'harga_modal' => 95000000,
                'harga_jual' => 98500000,
                'status' => 'tersedia'
            ],
        ];

        foreach ($motorData as $motor) {
            Kendaraan::create($motor);
        }
    }
}
