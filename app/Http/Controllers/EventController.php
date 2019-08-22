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
    public static function all() {
        return Event::all();
    }
    public static function mine($myId) {
        return Event::where('user_id', $myId)->get();
    }
    public static function get($eventId) {
        return Event::where('id', $eventId)->first();
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
        $all = json_encode(Input::get(), true);
        $tickets = json_decode($all, true);

        $myData = UserCtrl::me();
        $myId = $myData->id;

        foreach($tickets as $ticketId => $qty) {
            if($ticketId != "_token" && $qty > 0) {
                $ticket = TicketCtrl::getTicketInfo($ticketId);
                $totalPay = $ticket->price * $qty;

                $books = Booking::create([
                    'ticket_id' => $ticketId,
                    'user_id' => $myId,
                    'qty' => $qty,
                    'total_pay' => $totalPay,
                    'status' => 0,
                ]);
            }
        }
    }
}
