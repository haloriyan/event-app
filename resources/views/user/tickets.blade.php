@extends('layouts.dashboard')

@inject('EventCtrl', 'App\Http\Controllers\EventController')

@section('head.dependencies')
<style>
    a {
        text-decoration: underline;
        color: #f15b2d;
    }
</style>
@endsection

@section('content')
<div class="bg-putih rounded bayangan-5 p-3 mb-5">
    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Ticket Name</th>
                <th>Qty</th>
                <th>Status</th>
            </tr>
            <tbody>
                @foreach ($tickets as $ticket)
                    @php
                        if($ticket->status == 0) {
                            $showStatus = "Unpaid";
                        }else if($ticket->status == 1) {
                            $showStatus = "Paid";
                        }else if($ticket->status == 9) {
                            $showStatus = "Attended";
                        }
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('ticket.detail', $ticket->id) }}" target="_blank">
                                {{ $EventCtrl::get($ticket->tickets->event_id)->title }}
                                <i class="fas fa-qrcode"></i>
                            </a>
                        </td>
                        <td>{{ $ticket->tickets->name }}</td>
                        <td>{{ $ticket->qty }}</td>
                        <td>{{ $showStatus }}</td>
                    </tr>
                @endforeach
            </tbody>
        </thead>
    </table>
</div>
@endsection