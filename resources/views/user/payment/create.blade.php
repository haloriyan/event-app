@extends('layouts.eventForm')

@section('title', 'Create Event | Event Kota')

@section('content')
<form class="rata-tengah mt-5" action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="lebar-40 rata-kiri d-inline-block">
        <h2>Create Payment Method</h2>
        <div class="bg-putih rounded bayangan-5 p-3">
            <div>Account type :</div>
            <input type="text" class="box" placeholder="e.g : Bank name / Paypal" name="type" required>
            <div class="mt-2">Account name :</div>
            <input type="text" class="box" name="account_name" required>
            <div class="mt-2">Account ID :</div>
            <input type="text" class="box" placeholder="e.g : bank number / paypal email" required name="account_id">
            <button class="biru lebar-100 mt-4">Create</button>
        </div>
    </div>
</form>
@endsection