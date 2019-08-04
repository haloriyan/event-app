@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<form action="{{ route('user.register') }}" method="POST">
    {{ csrf_field() }}
    <div>Nama :</div>
    <input type="text" class="box" name="name">
    <div class="mt-2">Email :</div>
    <input type="email" class="box" name="email">
    <div class="mt-2">Password :</div>
    <input type="password" class="box" name="password">
    <button class="lebar-100 mt-4 bg-biru">Register</button>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="bg-merah-transparan mt-2 p-2 rounded">
                {{ $error }}
            </div>
        @endforeach
    @endif
</form>
@endsection