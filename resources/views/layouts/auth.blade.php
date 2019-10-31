<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Event Kota</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
<div class="rata-tengah">
    <div class="d-inline-block lebar-35 mt-5 rata-kiri">
        <h1>@yield('title')</h1>
        <div class="bg-putih rounded bayangan-5 p-3">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>