<?php  

namespace App\Http\Controllers;  

use App\Models\Article; // Pastikan ada ini  
use Illuminate\Http\Request;  

class ArticleController extends Controller  
{  
    public function index()  
    {  
        $articles = Article::getDummyArticles(); // Pastikan ini juga benar  
        return view('articles.index', compact('articles'));  
    }  

    public function show($id)  
    {  
        $article = Article::find($id);  
        if (!$article) {  
            abort(404);  
        }  
        return view('articles.show', compact('article'));  
    }  
}  