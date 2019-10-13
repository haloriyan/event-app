@extends('layouts.dashboardAdmin')

@section('content')
<div class="bag bagi-2">
    <div class="wrap">
        <div class="bg-putih rounded bayangan-5 p-1">
            <div class="wrap">
                <h1>{{ $events }}</h1>
                <span class="teks-transparan">active events</span>
            </div>
        </div>
    </div>
</div>
<div class="bag bagi-2">
    <div class="wrap">
        <div class="bg-putih rounded bayangan-5 p-1">
            <div class="wrap">
                <h1>{{ $users }}</h1>
                <span class="teks-transparan">users registered</span>
            </div>
        </div>
    </div>
</div>
@endsection