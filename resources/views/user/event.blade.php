@extends('layouts.dashboard')

@section('content')
<h1>My Events</h1>
<div class="bg-putih rounded bayangan-5 p-3">
    @if ($events->count() == 0)
        <h3>No event available</h3>
    @else
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th class="lebar-25"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>
                            <a href="{{ route('ticket.info', $item->id) }}">
                                <button class="biru-alt"><i class="fas fa-tags"></i></button>
                            </a>
                            <form action="{{ route('event.delete', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button class="merah"><i class="fas fa-trash"></i></button>
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