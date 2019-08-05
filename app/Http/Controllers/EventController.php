<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
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
    public function edit() {
        // 
    }
    public function update(Request $req) {
        // 
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

        return view('event.detail')->with([
            'event' => $evt,
            'contact' => $getContact,
        ]);
    }
}
