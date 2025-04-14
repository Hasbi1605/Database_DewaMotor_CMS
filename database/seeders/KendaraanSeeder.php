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
    }  
}  
