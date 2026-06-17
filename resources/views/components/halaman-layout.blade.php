@props(['title'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title)?$title:'judul default' }}</title>
</head>
<body>
    <h1>Halo ini halaman depan</h1>
    {{$slot}}
    <p>Tanggal : {{ $tanggal }}</p>
    <p>penulis : {{ $penulis }}</p>
</body>
</html>
