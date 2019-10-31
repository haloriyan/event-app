@extends('layouts.dashboardAdmin')

@section('head.dependencies')
<style>
    .cats {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 90px;
        cursor: pointer;
        margin-bottom: 10px;
    }
    .cats form { display: none; }
    .cats:hover form { display: inline-block; }
    .btn {
        padding: 0px;
        height: 10px;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
<h1>City</h1>
<div class="bg-putih rounded bayangan-5 p-3">
    <h3>List of cities :</h3>
    @if ($cities->count() == 0)
        <p>Cities data not foudn</p>
    @else
        @foreach ($cities as $city)
            {{-- {{ $city->city }} --}}
            <div class="cats bg-biru-transparan">
                {{ $city->city }}
                <form action="{{ route('city.delete', $city->id) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn teks-merah"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        @endforeach
    @endif
    <h3>Add new city :</h3>
    <form action="{{ route('city.store') }}" method="POST">
        {{ csrf_field() }}
        <input type="text" class="box lebar-85" placeholder="City name..." name="city">
        <button class="tbl biru">Create</button>
    </form>
</div>
@endsection