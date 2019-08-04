<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('fw/fontawesome-all.min.css') }}">
    @yield('additional.dependencies')
</head>
<body>

<nav class="menu">
    <a href="{{ route('user.dashboard') }}">
        <li class="{{ (Route::currentRouteName() == 'user.dashboard') ? 'active' : 'none' }}">
            <div class="icon"><i class="fas fa-home"></i></div>
            <span>Dashboard</span>
        </li>
    </a>
    <a href="{{ route('user.events') }}">
        <li class="{{ (Route::currentRouteName() == 'user.events') ? 'active' : 'none' }}">
            <div class="icon"><i class="fas fa-calendar"></i></div>
            <span>My Events</span>
        </li>
    </a>
    <a href="{{ route('user.settings') }}">
        <li class="{{ (Route::currentRouteName() == 'user.settings') ? 'active' : 'none' }}">
            <div class="icon"><i class="fas fa-cogs"></i></div>
            <span>Settings</span>
        </li>
    </a>
    <li>
        <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
        <span>Log Out</span>
    </li>
</nav>

<div class="container">
    @yield('content')
</div>

<script src="{{ asset('js/embo.js') }}"></script>
@yield('javascript')

</body>
</html>