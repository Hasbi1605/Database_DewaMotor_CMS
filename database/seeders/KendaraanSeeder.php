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
            [
                'nomor_rangka' => 'MH1KW2229PK123458',
                'nomor_mesin' => 'KW22E1123458',
                'nomor_polisi' => 'B1234KGM',
                'merek' => 'Honda',
                'model' => 'Vario 125 CBS',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 24000000,
                'harga_jual' => 26000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1PC2229PK234569',
                'nomor_mesin' => 'PC22E1234569',
                'nomor_polisi' => 'B5678KGM',
                'merek' => 'Honda',
                'model' => 'PCX CBS',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 33000000,
                'harga_jual' => 35500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1BD2229PK345680',
                'nomor_mesin' => 'BD22E1345680',
                'nomor_polisi' => 'B9012KGM',
                'merek' => 'Honda',
                'model' => 'Beat Street',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 19000000,
                'harga_jual' => 20500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1SC2229PK456791',
                'nomor_mesin' => 'SC22E1456791',
                'nomor_polisi' => 'B3456KGM',
                'merek' => 'Honda',
                'model' => 'Scoopy Prestige',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 22000000,
                'harga_jual' => 23500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1NX2229PK567892',
                'nomor_mesin' => 'NX22E1567892',
                'nomor_polisi' => 'B7890KGM',
                'merek' => 'Yamaha',
                'model' => 'NMAX Connected',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 36000000,
                'harga_jual' => 38500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1AX2229PK678903',
                'nomor_mesin' => 'AX22E1678903',
                'nomor_polisi' => 'B1234KHM',
                'merek' => 'Yamaha',
                'model' => 'Aerox Connected',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 29000000,
                'harga_jual' => 31000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1MF2229PK789014',
                'nomor_mesin' => 'MF22E1789014',
                'nomor_polisi' => 'B5678KHM',
                'merek' => 'Yamaha',
                'model' => 'Mio Fino',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 20000000,
                'harga_jual' => 21500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1FL2229PK890125',
                'nomor_mesin' => 'FL22E1890125',
                'nomor_polisi' => 'B9012KHM',
                'merek' => 'Yamaha',
                'model' => 'Fazzio Luxury',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 23000000,
                'harga_jual' => 24500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'ML1VS2229PK901236',
                'nomor_mesin' => 'VS22E1901236',
                'nomor_polisi' => 'B3456KHM',
                'merek' => 'Vespa',
                'model' => 'Sprint S',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 56000000,
                'harga_jual' => 59000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'ML1PS2229PK012347',
                'nomor_mesin' => 'PS22E1012347',
                'nomor_polisi' => 'B7890KHM',
                'merek' => 'Vespa',
                'model' => 'Primavera S',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 53000000,
                'harga_jual' => 56000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1KB2229PK123459',
                'nomor_mesin' => 'KB22E1123459',
                'nomor_polisi' => 'B1234KIM',
                'merek' => 'Honda',
                'model' => 'Vario 160 CBS',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 26000000,
                'harga_jual' => 28000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1AC2229PK234570',
                'nomor_mesin' => 'AC22E1234570',
                'nomor_polisi' => 'B5678KIM',
                'merek' => 'Honda',
                'model' => 'ADV 160 CBS',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 37000000,
                'harga_jual' => 39500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1CR2229PK345681',
                'nomor_mesin' => 'CR22E1345681',
                'nomor_polisi' => 'B9012KIM',
                'merek' => 'Honda',
                'model' => 'CBR 250RR',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 65000000,
                'harga_jual' => 68000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1R32229PK456792',
                'nomor_mesin' => 'R322E1456792',
                'nomor_polisi' => 'B3456KIM',
                'merek' => 'Yamaha',
                'model' => 'R3',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 68000000,
                'harga_jual' => 71500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1M32229PK567893',
                'nomor_mesin' => 'M322E1567893',
                'nomor_polisi' => 'B7890KIM',
                'merek' => 'Yamaha',
                'model' => 'MT-25',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 55000000,
                'harga_jual' => 57500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1TM2229PK678904',
                'nomor_mesin' => 'TM22E1678904',
                'nomor_polisi' => 'B1234KJM',
                'merek' => 'Yamaha',
                'model' => 'Tmax',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 85000000,
                'harga_jual' => 88000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1RB2229PK789015',
                'nomor_mesin' => 'RB22E1789015',
                'nomor_polisi' => 'B5678KJM',
                'merek' => 'Honda',
                'model' => 'Rebel 500',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 78000000,
                'harga_jual' => 81000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1RF2229PK890126',
                'nomor_mesin' => 'RF22E1890126',
                'nomor_polisi' => 'B9012KJM',
                'merek' => 'Honda',
                'model' => 'Revo',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 17000000,
                'harga_jual' => 18500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1WR2229PK901237',
                'nomor_mesin' => 'WR22E1901237',
                'nomor_polisi' => 'B3456KJM',
                'merek' => 'Yamaha',
                'model' => 'WR 155',
                'tahun_pembuatan' => 2024,
                'harga_modal' => 37000000,
                'harga_jual' => 39500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1KC2225PK987654',
                'nomor_mesin' => 'KC22E1987654',
                'nomor_polisi' => 'B4321KJM',
                'merek' => 'Honda',
                'model' => 'ADV 160',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 36000000,
                'harga_jual' => 38500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1NM2225PK876543',
                'nomor_mesin' => 'NM22E1876543',
                'nomor_polisi' => 'B8765KJM',
                'merek' => 'Yamaha',
                'model' => 'NMAX Connected',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 38000000,
                'harga_jual' => 40500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MK1VD2225PK765432',
                'nomor_mesin' => 'VD22E1765432',
                'nomor_polisi' => 'B2109KJM',
                'merek' => 'Kawasaki',
                'model' => 'Ninja ZX-25R',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 102000000,
                'harga_jual' => 108000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MS1BG2225PK654321',
                'nomor_mesin' => 'BG22E1654321',
                'nomor_polisi' => 'B6543KJM',
                'merek' => 'Suzuki',
                'model' => 'Burgman Street',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 32000000,
                'harga_jual' => 34500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1CB2225PK543210',
                'nomor_mesin' => 'CB22E1543210',
                'nomor_polisi' => 'B0987KJM',
                'merek' => 'Honda',
                'model' => 'CBR 250RR',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 75000000,
                'harga_jual' => 79500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MK1VR2225PK321098',
                'nomor_mesin' => 'VR22E1321098',
                'nomor_polisi' => 'B8901KJM',
                'merek' => 'Kawasaki',
                'model' => 'Versys 650',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 145000000,
                'harga_jual' => 152000000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MS1GS2225PK210987',
                'nomor_mesin' => 'GS22E1210987',
                'nomor_polisi' => 'B2345KJM',
                'merek' => 'Suzuki',
                'model' => 'GSX-R150',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 35000000,
                'harga_jual' => 37500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MH1ST2225PK109876',
                'nomor_mesin' => 'ST22E1109876',
                'nomor_polisi' => 'B6789KJM',
                'merek' => 'Honda',
                'model' => 'Street RS',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 28000000,
                'harga_jual' => 30500000,
                'status' => 'tersedia'
            ],
            [
                'nomor_rangka' => 'MG1XS2225PK098765',
                'nomor_mesin' => 'XS22E1098765',
                'nomor_polisi' => 'B0123KJM',
                'merek' => 'Yamaha',
                'model' => 'XSR 155',
                'tahun_pembuatan' => 2025,
                'harga_modal' => 36000000,
                'harga_jual' => 38500000,
                'status' => 'tersedia'
            ]
        ];

        foreach ($motorData as $motor) {
            Kendaraan::create($motor);
        }
    }
}
