@extends('layouts.dashboardAdmin')
@section('head.dependencies')
<style>
    td.action a { margin: 0px 10px; }
</style>    
@endsection

@php
use \App\Http\Controllers\EventController as EventCtrl;
@endphp

@section('content')
<h1>Events</h1>
<div class="bg-putih rounded bayangan-5 p-3">
    @if ($events->count() == 0)
        <h2>No active event</h2>
    @else
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th class="lebar-20"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td class="rata-tengah action">
                            <a href="{{ route('event.detail', EventCtrl::slug($event->title)) }}" target="_blank"><i class="teks-biru fas fa-eye"></i></a>
                            <a href="{{ route('event.delete', $event->id) }}"><i class="teks-merah fas fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection