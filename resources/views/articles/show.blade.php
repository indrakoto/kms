<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }}</title>
</head>
<body>

    <h1>{{ $article->title }}</h1>
    <p>{{!! $article->content !!}}</p> <!-- Menampilkan konten artikel -->
    <p>{{ $article->file_path }}</p> <!-- Menampilkan konten artikel -->
    <a href="{{ url('/home') }}">Back to Home</a>

</body>
</html>
