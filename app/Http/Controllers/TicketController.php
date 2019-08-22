<?php

namespace App\Http\Controllers;

use App\Event;
use App\Ticket;
use App\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\EventController as EventCtrl;

class TicketController extends Controller
{
    public static function get($eventId) {
        return Ticket::where('event_id', $eventId)->get();
    }
    public static function getTicketInfo($ticketId) {
        return Ticket::where('id', $ticketId)->first();
    }
    public static function haveTicket($userId, $eventId) {
        $getTicket = Ticket::where('event_id', $eventId)->get();
        foreach($getTicket as $ticket) {
            $cekBooking[] = Booking::where([
                ['ticket_id', $ticket->id],
                ['user_id', $userId]
            ])
            ->count('id');
        }
        foreach($cekBooking as $key => $value) {
            return ($value == 1) ? true : false;
        }
        // return ($get->count() > 0) ? true : false;
    }
    public function info($eventId) {
        $getTicket = Ticket::where('event_id', $eventId)->get();
        $evt = EventCtrl::get($eventId);

        return view('event.ticket')->with(['tickets' => $getTicket, 'event' => $evt]);
    }
    public function create($eventId) {
        $evt = EventCtrl::get($eventId);
        return view('event.createTicket')->with(['event' => $evt]);
    }
    public function edit($ticketId) {
        $ticket = Ticket::where('id', $ticketId)->first();
        $eventId = $ticket->event_id;
        $evt = EventCtrl::get($eventId);
        return view('event.editTicket')->with(['event' => $evt, 'ticket' => $ticket]);
    }
    public function update($ticketId, Request $req) {
        $ticket = Ticket::find($ticketId);
        $ticket->name = $req->name;
        $ticket->price = $req->price;
        $ticket->stock = $req->stock;
        $ticket->save();

        return redirect()->route('ticket.info', $req->eventId);
    }
    public function store($eventId, Request $req) {
        $tick = Ticket::create([
            'event_id' => $eventId,
            'name' => $req->name,
            'price' => $req->price,
            'stock' => $req->stock,
        ]);

        return redirect()->route('ticket.info', $eventId);
    }
    public function delete($eventId, Request $req) {
        $tick = Ticket::find($req->id);
        $tick->delete();
        
        return redirect()->route('ticket.info', $eventId);
    }
    public static function deleteAll($eventId) {
        $tick = Ticket::where('event_id', $eventId);
        $tick->delete();

        return redirect()->route('ticket.info', $eventId);
    }
}
