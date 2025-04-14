<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class Article extends Model  
{  
    use HasFactory;  

    // Hapus atau modifikasi metode all()  
    protected static function getDummyData()  
    {  
        return [  
            ['id' => 1, 'title' => 'Belajar Laravel', 'content' => 'Laravel adalah framework PHP terbaik.'],  
            ['id' => 2, 'title' => 'Pengenalan MVC', 'content' => 'MVC membantu memisahkan logika.'],  
        ];  
    }  

    // Fungsi untuk mengambil data dummy  
    public static function getDummyArticles()  
    {  
        return self::getDummyData();  
    }  

    public static function find($id)  
    {  
        $articles = self::getDummyData();  
        foreach ($articles as $article) {  
            if ($article['id'] == $id) {  
                return $article;  
            }  
        }  
        return null;  
    }  
}  