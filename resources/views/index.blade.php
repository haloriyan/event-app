<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda Kota</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fw/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>

@php
use \App\Http\Controllers\EventController as EventCtrl;
@endphp

<div class="atas bg-biru">
    <h1 class="title">Agenda Kota</h1>
    <div class="pencarian ke-kanan bag bag-5">
        {{ csrf_field() }}
        <input type="text" class="box" name="q">
        <button id="cari"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="filter bayangan-5 p-2 rounded">
    haha
</div>

<div class="container">
    @foreach ($events as $item)
        @php
            $displayedDateStart = Carbon::parse($item->date_start)->format('M d, Y');
            $displayedDateEnd = Carbon::parse($item->date_end)->format('M d, Y');
            $displayedTimeStart = Carbon::parse($item->time_start)->format('H:i');
            $displayedTimeEnd = Carbon::parse($item->time_end)->format('H:i');
        @endphp
        <div class="event">
            <div class="cover" style="background: url({{ asset('storage/cover/'.$item->cover) }}"></div>
            <div class="wrap">
                <h3><a href="{{ route('event.detail', EventCtrl::slug($item->title)) }}">{{ $item->title }}</a></h3>
                <p class="teks-kecil">
                    <i class="fas fa-calendar"></i> &nbsp; {{ $displayedDateStart . " - " . $displayedDateEnd }} <br /> <br />
                    <i class="fas fa-clock"></i> &nbsp; {{ $displayedTimeStart . " - " . $displayedTimeEnd }}<br /><br />
                    <i class="fas fa-map-marker"></i> &nbsp; {{ $item->address }}
                </p>
            </div>
        </div>
    @endforeach
</div>
    
</body>
</html>