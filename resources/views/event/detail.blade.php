<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $event->title }} | Agenda Kota</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fw/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>
<body>

<div class="atas bg-biru">
    <h1 class="title">Agenda Kota</h1>
    <div class="pencarian ke-kanan bag bag-5">
        {{ csrf_field() }}
        <input type="text" class="box" name="q">
        <button id="cari"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="kanan">
    @if ($haveTicket == 0)
        <a href="{{ route('event.ticket', $sluggedTitle) }}">
            <button class="lebar-100 biru rounded-circle">Purchase</button>
        </a>
    @elseif ($haveTicket == 2)
        @php
            $thisUrl = route('event.detail', $sluggedTitle)
        @endphp
        <a href="{{ route('user.loginPage', base64_encode($thisUrl)) }}">
            <button class="lebar-100 biru rounded-circle">Login for purchase ticket</button>
        </a>
    @else
        <a href="#">
            <button class="lebar-100 biru rounded-circle">Check your ticket</button>
        </a>
    @endif
    <div class="mt-4 bg-putih bayangan-5 p-3">
        @php
            $displayedDateStart = Carbon::parse($event->date_start)->format('M d, Y');
            $displayedDateEnd = Carbon::parse($event->date_end)->format('M d, Y');
            $displayedTimeStart = Carbon::parse($event->time_start)->format('H:i');
            $displayedTimeEnd = Carbon::parse($event->time_end)->format('H:i');
        @endphp
        <p>
            <i class="fas fa-calendar"></i> &nbsp; {{ $displayedDateStart }} - {{ $displayedDateEnd }}
        </p>
        <p>
            <i class="fas fa-clock"></i> &nbsp; {{ $displayedTimeStart }} - {{ $displayedTimeEnd }}
        </p>
        <p>
            <i class="fas fa-map-marker"></i> &nbsp; {{ $event->address }}
        </p>
    </div>
</div>

<div class="container">
    <div class="bg-putih bayangan-5 mb-5">
        <div class="cover" style="background: url({{ asset('storage/cover/'.$event->cover) }})"></div>
        <div class="wrap pb-2">
            <h2>{{ $event->title }}</h2>
            <p class="teks-kecil">oleh {{ $event->users->name }}</p>
            <p class="mt-2">
                {{ $event->description }}
            </p>
        </div>
    </div>
    <div class="bg-putih bayangan-5 mb-5 p-1">
        <div class="wrap">
            <h2>Contact Information</h2>
            @foreach ($contact as $item)
                @php
                    $type = strtolower($item->type);
                @endphp
                <a href="{{ $item->value }}">
                    <div class="bg-biru-transparan d-inline-block p-2    pl-3 pr-3 rounded-circle">
                        <i class="fab fa-{{ $type }}"></i> &nbsp; {{ $item->type }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
    
</body>
</html>