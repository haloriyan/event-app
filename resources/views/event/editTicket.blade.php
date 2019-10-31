@extends('layouts.eventForm')

@section('title', 'Edit Ticket | Event Kota')
@section('additional.dependencies')
<style>
    .bagError {
        position: fixed;
        top: 120px;left: 2.5%;
        width: 20%;
    }
</style>
@endsection

@php
function toIdr($angka) {
    return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
}
@endphp

<div class="bagError">
    @if ($errors->any())
        @foreach ($errors->all() as $item)
            <div class="bg-merah-transparan p-2 mb-2">
                {{ $item }}
            </div>
        @endforeach
    @endif
</div>

<form class="rata-tengah mt-5" action="{{ route('ticket.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="eventId" value="{{ $event->id }}">
    <input type="hidden" name="_method" value="put">
    <div class="lebar-40 rata-kiri d-inline-block">
        <h2>Edit "{{ $ticket->name }}" Ticket</h2>
        <div class="bg-putih rounded bayangan-5 p-3 mb-4">
            <div>Ticket name :</div>
            <input type="text" class="box" name="name" required placeholder="e.g : VIP, Premium, etc" value="{{ $ticket->name }}">
            <div class="mt-2">Price :</div>
            <input type="hidden" name="price" id="price" value="{{ $ticket->price }}">
            <input type="text" class="box" name="priceDisplay" id="priceDisplay" value="{{ toIdr($ticket->price) }}">
            <div class="mt-2">Stock</div>
            <input type="number" name="stock" class="box" value="{{ $ticket->stock }}">
        </div>
        
        <button class="lebar-100 biru mb-5">Update Changes</button>
    </div>
</form>

@section('javascript')
<script>
function formatRupiah(angka, prefix){
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	rupiah     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
function toAngka(angka) {
	return parseInt(angka.replace(/,.*|[^0-9]/g, ''), 10);
}

$("#priceDisplay").di('ketik', function() {
    let value = this.value
    let angka = formatRupiah(value, 'Rp. ')
    this.value = angka
    $("#price").isi(toAngka(value))
})
</script>
@endsection