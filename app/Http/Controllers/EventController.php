<?php

namespace App\Http\Controllers;

use App\Event;
use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\UserController as UserCtrl;
use App\Http\Controllers\TicketController as TicketCtrl;
use App\Http\Controllers\ContactController as ContactCtrl;

class EventController extends Controller
{
    public static function countEvent() {
        return Event::all(['id'])->count();
    }
    public static function active($dateNow) {
        return Event::where([
            ['date_end', '>=', $dateNow],
        ])->get();
    }
    public function inActive($dateNow) {
        return Event::where([
            ['date_end', '<=', $dateNow],
        ])->get();
    }
    public static function mine($myId) {
        return Event::where([
            ['user_id', $myId],
            ['status', 1],
        ])->get();
    }
    public static function get($eventId, $relationName = NULL) {
        if(!$relationName) {
            return Event::where('id', $eventId)->first();
        }else {
            return Event::where('id', $eventId)->with($relationName)->first();
        }
    }
    public function create() {
        return view('event.create');
    }
    public function store(Request $req) {
        $myData = UserCtrl::me();
        $evt = new Event;

        $validateData = $this->validate($req, [
            'cover' => 'image'
        ]);

        $cover = $req->file('cover');
        $coverFileName = $cover->getClientOriginalName();
        
        $evt = Event::create([
            'user_id' => $myData->id,
            'title' => $req->title,
            'description' => $req->description,
            'category' => $req->category,
            'address' => $req->address,
            'date_start' => $req->dateStart,
            'date_end' => $req->dateEnd,
            'time_start' => $req->timeStart,
            'time_end' => $req->timeEnd,
            'cover' => $coverFileName,
            'status' => 1,
        ]);

        $cover->storeAs('public/cover', $coverFileName);

        return redirect()->route('user.events');
    }
    public function edit($id) {
        $event = $this->get($id);
        return view('event.edit')->with(['event' => $event]);
    }
    public static function change($eventId, $didUpdate) {
        return Event::find($eventId)->update($didUpdate);
    }
    public function update($id, Request $req) {
        $evt = Event::find($id);

        $cover = $req->file('cover');

        $evt->title = $req->title;
        $evt->description = $req->description;
        $evt->category = $req->category;
        $evt->address = $req->address;
        $evt->date_start = $req->dateStart;
        $evt->date_end = $req->dateEnd;
        $evt->time_start = $req->timeStart;
        $evt->time_end = $req->timeEnd;
        if($cover != "") {
            $coverFileName = $cover->getClientOriginalName();
            $evt->cover = $coverFileName;
            $cover->storeAs('public/cover', $coverFileName);
        }

        $evt->save();

        return redirect()->route('user.events');
    }
    public function delete($id) {
        $evt = Event::find($id);
        $evt->delete();

        $deleteTicket = TicketCtrl::deleteAll($id);

        return redirect()->route('user.events');
    }
    public static function slug($title) {
        $cek = strpos($title, "-");
		if($cek > 0) {
			$res = implode(" ", explode("-", $title));
		}else {
			$res = implode("-", explode(" ", $title));
			$res = strtolower($res);
		}
		return $res;
    }
    public function detail($title) {
        $title = $this->slug($title);
        $evt = Event::where('title', 'LIKE', '%'.$title.'%')->with('users')->first();

        $userId = $evt->users->id;
        $getContact = ContactCtrl::mine($userId);

        $myData = UserCtrl::me();

        if($myData == "") {
            $haveTicket = 2;
        }else {
            $haveTicket = (TicketCtrl::haveTicket($myData->id, $evt->id)) ? 1 : 0;
        }

        return view('event.detail')->with([
            'event' => $evt,
            'contact' => $getContact,
            'sluggedTitle' => $this->slug($title),
            'haveTicket' => $haveTicket,
        ]);
    }
    public function ticketDetail($title) {
        $title = $this->slug($title);
        $event = Event::where('title', 'LIKE', '%'.$title.'%')->first();
        $ticket = TicketCtrl::get($event->id);
        return view('buyTicket')->with([
            'tickets' => $ticket,
            'event' => $event
        ]);
    }
    public function book($id, Request $req) {
        $input = Input::get();
        $all = json_encode(Input::get(), true);
        $tickets = json_decode($all, true);

        $myData = UserCtrl::me();
        $myId = $myData->id;

        foreach($tickets as $ticketId => $qty) {
            if($ticketId != "_token" && $ticketId != "eventId" && $qty > 0) {
                $ticket = TicketCtrl::getTicketInfo($ticketId);
                $totalPay = $ticket->price * $qty;

                $status = ($ticket->price == 0) ? 1 : 0;

                $books = Booking::create([
                    'ticket_id' => $ticketId,
                    'user_id' => $myId,
                    'qty' => $qty,
                    'total_pay' => $totalPay,
                    'status' => $status,
                ]);

                $updateTicket = TicketCtrl::decreaseQuota($ticketId, $qty);
            }
        }

        return redirect()->route('user.tickets');
    }
    public function getPeopleBooking($ticketId) {
        return Booking::where([
            ['ticket_id', $ticketId],
            ['status', 1],
        ])
        ->orWhere([
            ['ticket_id', $ticketId],
            ['status', 9],
        ])
        ->with('users')->get();
    }
    public function guests($eventId) {
        $myData = UserCtrl::me();
        $eventData = $this->get($eventId);
        $tickets = $this->getGuestsData($eventId);

        return view('event.guests')->with([
            'myData' => $myData,
            'tickets' => $tickets,
            'event' => $eventData,
        ]);
    }
    public function getGuestsData($eventId) {
        $tickets = TicketCtrl::get($eventId);

        $i = 0;
        foreach($tickets as $ticket) {
            $iPP = $i++;
            $ticket = json_decode($ticket, true);
            $tickets[$iPP]['guest'] = $this->getPeopleBooking($ticket['id']);
        }

        return $tickets;
    }
    public function attend(Request $req) {
        $id = $req->id;
        $update = Booking::find($id)->update([
            'status' => 9,
        ]);
    }
    public function toPay($ticketId) {
        $data = Booking::where('ticket_id', $ticketId)->first(['total_pay']);
        return $data->total_pay;
    }
    public function redeemPage($id) {
        $event = $this->get($id, 'tickets');
        $tickets = $event->tickets;

        $total = 0;

        foreach($tickets as $ticket) {
            $price = $ticket->price;
            $toPay = $this->toPay($ticket->id);
            $total += $toPay; 
        }

        return view('event.redeem')->with([
            'event' => $event,
            'total' => $total,
        ]);
    }
}
