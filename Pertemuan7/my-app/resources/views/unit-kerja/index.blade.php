<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>unit kerja</title>
</head>
<body>
    <h1>unit kerja</h1>
    <ul>
        @foreach ($unitkerja as $item)
        <li>{{ $item->kode," _ ",$item->nama}}</li>
        @endforeach
    </ul>
</body>
</html>