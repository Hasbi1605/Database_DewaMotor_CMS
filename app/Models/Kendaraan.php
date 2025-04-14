<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class Kendaraan extends Model  
{  
    use HasFactory;  

    protected $fillable = [  
        'nomor_rangka',   
        'nomor_mesin',   
        'nomor_polisi',   
        'merek',   
        'model',   
        'tahun_pembutan',   
        'harga_modal',   
        'harga_jual'  
    ];  

    // Contoh dummy data untuk testing  
    protected static function getDummyData()  
    {  
        return [  
            ['id' => 1, 'nomor_rangka' => 'R123456', 'nomor_mesin' => 'M123456', 'nomor_polisi' => 'B1234CD', 'merek' => 'Yamaha', 'model' => 'Nmax', 'tahun_pembutan' => 2020, 'harga_modal' => 200000000, 'harga_jual' => 22000000],  
            ['id' => 2, 'nomor_rangka' => 'R654321', 'nomor_mesin' => 'M654321', 'nomor_polisi' => 'B5678EF', 'merek' => 'Honda', 'model' => 'Pcx', 'tahun_pembutan' => 2021, 'harga_modal' => 180000000, 'harga_jual' => 20000000],  
        ];  
    }  

    // Mengambil semua kendaraan  
    public static function allData()  
    {  
        return [  
            ['id' => 1, 'nomor_rangka' => 'R123456', 'nomor_mesin' => 'M123456', 'nomor_polisi' => 'B1234CD', 'merek' => 'Yamaha', 'model' => 'Nmax', 'tahun_pembutan' => 2020, 'harga_modal' => 200000000, 'harga_jual' => 22000000],  
            ['id' => 2, 'nomor_rangka' => 'R654321', 'nomor_mesin' => 'M654321', 'nomor_polisi' => 'B5678EF', 'merek' => 'Honda', 'model' => 'Pcx', 'tahun_pembutan' => 2021, 'harga_modal' => 180000000, 'harga_jual' => 20000000],  
        ];  
    }  
}  