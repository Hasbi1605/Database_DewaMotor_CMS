<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;  
use App\Models\Kendaraan;  

class KendaraanSeeder extends Seeder  
{  
    public function run()  
    {  
        Kendaraan::create([  
            'nomor_rangka' => 'R123456',  
            'nomor_mesin' => 'M123456',  
            'nomor_polisi' => 'B1234CD',  
            'merek' => 'Yamaha',  
            'model' => 'Nmax',  
            'tahun_pembutan' => 2020,  
            'harga_modal' => 20000000,  
            'harga_jual' => 22000000,  
        ]);  

        Kendaraan::create([  
            'nomor_rangka' => 'R654321',  
            'nomor_mesin' => 'M654321',  
            'nomor_polisi' => 'B5678EF',  
            'merek' => 'Honda',  
            'model' => 'Pcx',  
            'tahun_pembutan' => 2021,  
            'harga_modal' => 18000000,  
            'harga_jual' => 20000000,  
        ]);  

        // Tambahkan 10 data kendaraan baru
        Kendaraan::create([
            'nomor_rangka' => 'R789012',
            'nomor_mesin' => 'M789012',
            'nomor_polisi' => 'B9101GH',
            'merek' => 'Suzuki',
            'model' => 'Satria',
            'tahun_pembutan' => 2019,
            'harga_modal' => 15000000,
            'harga_jual' => 17000000,
        ]);

        Kendaraan::create([
            'nomor_rangka' => 'R345678',
            'nomor_mesin' => 'M345678',
            'nomor_polisi' => 'B1122IJ',
            'merek' => 'Kawasaki',
            'model' => 'Ninja',
            'tahun_pembutan' => 2022,
            'harga_modal' => 30000000,
            'harga_jual' => 35000000,
        ]);

        Kendaraan::create([
            'nomor_rangka' => 'R901234',
            'nomor_mesin' => 'M901234',
            'nomor_polisi' => 'B3344KL',
            'merek' => 'Daihatsu',
            'model' => 'Xenia',
            'tahun_pembutan' => 2020,
            'harga_modal' => 180000000,
            'harga_jual' => 200000000,
        ]);

        Kendaraan::create([
            'nomor_rangka' => 'R567890',
            'nomor_mesin' => 'M567890',
            'nomor_polisi' => 'B5566MN',
            'merek' => 'Toyota',
            'model' => 'Fortuner',
            'tahun_pembutan' => 2021,
            'harga_modal' => 450000000,
            'harga_jual' => 500000000,
        ]);

        Kendaraan::create([
            'nomor_rangka' => 'R234567',
            'nomor_mesin' => 'M234567',
            'nomor_polisi' => 'B7788OP',
            'merek' => 'Mitsubishi',
            'model' => 'Pajero',
            'tahun_pembutan' => 2022,
            'harga_modal' => 500000000,
            'harga_jual' => 550000000,
        ]);

        Kendaraan::create([
            'nomor_rangka' => 'R890123',
            'nomor_mesin' => 'M890123',
            'nomor_polisi' => 'B9900QR',
            'merek' => 'Isuzu',
            'model' => 'Panther',
            'tahun_pembutan' => 2018,
            'harga_modal' => 250000000,
            'harga_jual' => 280000000,
        ]);

        Kendaraan::create([
            'nomor_rangka' => 'R678901',
            'nomor_mesin' => 'M678901',
            'nomor_polisi' => 'B1122ST',
            'merek' => 'Ford',
            'model' => 'Ranger',
            'tahun_pembutan' => 2023,
            'harga_modal' => 600000000,
            'harga_jual' => 650000000,
        ]);

        Kendaraan::create([
            'nomor_rangka' => 'R345678',
            'nomor_mesin' => 'M345678',
            'nomor_polisi' => 'B3344UV',
            'merek' => 'Chevrolet',
            'model' => 'Trailblazer',
            'tahun_pembutan' => 2021,
            'harga_modal' => 400000000,
            'harga_jual' => 450000000,
        ]);

        Kendaraan::create([
            'nomor_rangka' => 'R901234',
            'nomor_mesin' => 'M901234',
            'nomor_polisi' => 'B5566WX',
            'merek' => 'Hyundai',
            'model' => 'Santa Fe',
            'tahun_pembutan' => 2022,
            'harga_modal' => 350000000,
            'harga_jual' => 400000000,
        ]);
    }  
}
