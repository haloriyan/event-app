@extends('layouts.dashboard')

@section('content')
<h1>My Events</h1>
<p class="teks-transparan">This will show events was you created</p>
<div class="bg-putih rounded bayangan-5 p-3 mt-4">
    @if ($events->count() == 0)
        <h3>No event available</h3>
        <a href="{{ route('event.create') }}">
            <button class="biru mt-2">Create one</button>
        </a>
    @else
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th><i class="fas fa-calendar"></i></th>
                    <th class="lebar-30"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>
                            @php
                                $displayedDateStart = Carbon::parse($item->date_start)->format('M d, Y');
                                $displayedDateEnd = Carbon::parse($item->date_end)->format('M d, Y');
                            @endphp
                            {{ $displayedDateStart }} - {{ $displayedDateEnd }}
                        </td>
                        <td class="rata-kanan">
                            <a href="{{ route('event.edit', $item->id) }}">
                                <button class="p-1 kuning-alt"><i class="fas fa-edit"></i></button>
                            </a>
                            <a href="{{ route('event.guests', $item->id) }}">
                                <button class="p-1 hijau-alt"><i class="fas fa-users"></i></button>
                            </a>
                            <a href="{{ route('ticket.info', $item->id) }}">
                                <button class="p-1 biru-alt"><i class="fas fa-tags"></i></button>
                            </a>
                            <form action="{{ route('event.delete', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button class="p-1 merah"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('event.create') }}">
            <button class="biru mt-2">Create another</button>
        </a>
    @endif
</div>
@endsection