<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Kota</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fw/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>

@php
use \App\Http\Controllers\EventController as EventCtrl;
@endphp

@include('layouts.header')

<div class="filter bayangan-5 p-2 rounded">
    <div>
        <input type="hidden" value="{{ $filter }}" id="filter">
        Explore by city :
        <select name="city" class="box mt-1" onchange="changeFilter({ type: 'city', value: this.value })">
            <option value="">All cities</option>
            @foreach ($cities as $city)
                @php
                    $filterJson = json_decode($filter, true);
                    $selected = $filterJson['city'] == $city->city ? "selected" : "";
                @endphp
                <option {{ $selected }}>{{ $city->city }}</option>
            @endforeach
        </select>
    </div>
    <div class="mt-2">
        Explore by category :
        <select name="city" class="box mt-1" onchange="changeFilter({ type: 'category', value: this.value })">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                @php
                    $selected = $filterJson['category'] == $category->category ? "selected" : "";
                @endphp
                <option {{ $selected }}>{{ $category->category }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="container">
    @if ($events->count() == 0)
        <h2>No any event found :(</h2>
        <p>Try to search another title and filter</p>
    @else
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
    @endif
    <div class="event rata-tengah mt-2" style="width: 100% !important;background: none;box-shadow: none;">
        {{ $events->links() }}
    </div>
</div>
    
<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script>
const filter = JSON.parse(document.querySelector("#filter").value)
const redirectFilter = (filter) => {
    let pattern = ""
    pattern += "&q=" + filter.q
    pattern += "&city=" + filter.city
    pattern += "&category=" + filter.category
    document.location = './?filter=yes' + pattern
}
const filterCity = (city) => {
    filter['city'] = city
}
const filterCategory = (category) => {
    filter['category'] = category
}
const filterQ = (q) => {
    filter['q'] = q
}
const changeFilter = (props) => {
    const type = props.type
    if(type == "city") {
        filterCity(props.value)
    }else if(type == "category") {
        filterCategory(props.value)
    }else if(type == "q") {
        filterQ(props.value)
    }
    redirectFilter(filter)
}

var elem = document.querySelector('.container');
var msnry = new Masonry( elem, {
    itemSelector: '.event',
    columnWidth: 14,
    containerStyle: null
});
</script>

</body>
</html>