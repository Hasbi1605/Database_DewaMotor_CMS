<!DOCTYPE html>  
<html>  
<head>  
    <title>Daftar Artikel</title>  
</head>  
<body>  
    <h1>Daftar Artikel</h1>  
    <ul>  
        @foreach ($articles as $article)  
            <li><a href="/articles/{{ $article['id'] }}">{{ $article['title'] }}</a></li>  
        @endforeach  
    </ul>  
</body>  
</html>  