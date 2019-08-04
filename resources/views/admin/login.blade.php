@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')
<form action="{{ route('admin.login') }}" method="POST">
    {{ csrf_field() }}
    <div>Email :</div>
    <input type="email" class="box" name="email">
    <div class="mt-2">Password :</div>
    <input type="password" class="box" name="password">
    <button class="lebar-100 mt-4 bg-biru">Login</button>

    @if ($errors->any())
        <div class="bg-merah-transparan mt-2 p-2 rounded">
            {{ $errors->first() }}
        </div>
    @endif
</form>
@endsection