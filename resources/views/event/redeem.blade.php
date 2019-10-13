@extends('layouts.dashboard')

@php
function toIdr($angka) {
    return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
}
@endphp

@section('content')
<h1>Redeem</h1>
<p class="teks-transparan">{{ $event->title }}</p>
<div class="bg-putih rounded bayangan-5 p-1">
    <div class="wrap">
        <h3>Total Saldo : {{ toIdr($total) }}</h3>
        <form action="{{ route('redeem.store') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="saldo" value="{{ $total }}">
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <button class="biru">Redeem!</button>
        </form>
    </div>
</div>
@endsection