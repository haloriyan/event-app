@extends('layouts.dashboard')

@php
function toIdr($angka) {
    return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
}
@endphp

@section('content')
<h1>Ticket for {{ $event->title }}</h1>
<div class="bg-putih rounded bayangan-5 p-3">
    @if ($tickets->count() == 0)
        <h3>No ticket available</h3>
        <a href="{{ route('ticket.create', $event->id) }}">
            <button class="biru">Create One</button>
        </a>
    @else
        <table>
            <thead>
                <tr>
                    <th>Ticket name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th style="width: 20%;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ toIdr($item->price) }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>
                            <a href="{{ route('ticket.edit', $item->id) }}">
                                <button class="hijau"><i class="fas fa-edit"></i></button>
                            </a>
                            <form action="{{ route('ticket.delete', $event->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button class="merah"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('ticket.create', $event->id) }}">
            <button class="biru mt-2">Add More</button>
        </a>
        <a href="{{ route('user.events') }}">
            <button class="biru-alt mt-2 ml-1">back to Event List</button>
        </a>
    @endif
</div>
@endsection