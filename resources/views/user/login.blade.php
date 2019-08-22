@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form action="{{ route('user.login') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="redirectTo" value="{{ $redirectTo }}">
    <div>Email :</div>
    <input type="email" class="box" name="email">
    <div class="mt-2">Password :</div>
    <input type="password" class="box" name="password">
    <button class="lebar-100 mt-4 bg-biru">Login</button>

    @if ($errors->any())
        @foreach ($errors as $item)
            <div class="bg-merah-transparan mt-2 p-2 rounded">
                {{ $item }}
            </div>
        @endforeach
    @endif
</form>
@endsection