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
        'tahun_pembuatan',  
        'harga_modal',   
        'harga_jual',  
    ];  
}