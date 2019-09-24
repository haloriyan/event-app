<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ContactController as ContactCtrl;
use App\Http\Controllers\EventController as EventCtrl;
use App\Http\Controllers\PaymentController as PaymentCtrl;
use App\Http\Controllers\TicketController as TicketCtrl;

class UserController extends Controller
{
    public static function me() {
        return Auth::guard('user')->user();
    }
    public function index() {
        $dateNow = date('Y-m-d');
        $evt = EventCtrl::active($dateNow);
        return view('index')->with(['events' => $evt]);
    }
    public function loginPage($redirectTo = NULL) {
        return view('user.login')->with(['redirectTo' => $redirectTo]);
    }
    public function registerPage() {
        return view('user.register');
    }
    public function login(Request $req) {
        $email = $req->email;
        $password = $req->password;
        $redirectTo = base64_decode($req->redirectTo);

        $login = Auth::guard('user')->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if(!$login) {
            return redirect()->route('user.loginPage')->withErrors(['Email / Password salah!']);
        }

        if($redirectTo == "") {
            return redirect()->route('user.dashboard');
        }else {
            return redirect($redirectTo);
        }
    }
    public function register(Request $req) {
        $validateData = $this->validate($req, [
            'name' => 'required',
            'email' => 'email',
            'password' => 'min:6',
            'event_active' => '[]'
        ]);

        $reg = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'photo' => 'default.png',
            'status' => '1',
        ]);

        return redirect()->route('user.dashboard');
    }
    public static function patch($col, $val, $userId) {
        return User::find($userId)->update([$col => $val]);
    }
    public function dashboard() {
        return view('user.dashboard');
    }
    public function settingsPage() {
        $myData = $this->me();
        $myContact = ContactCtrl::mine($myData->id);
        return view('user.settings')->with([
            'myData' => $myData,
            'myContact' => $myContact,
            'socials' => ['Facebook','Instagram','Twitter','Linkedin','Whatsapp']
        ]);
    }
    public function eventsPage() {
        $myData = $this->me();
        $myId = $myData->id;
        $myEvent = EventCtrl::mine($myId);

        return view('user.event')->with(['events' => $myEvent]);
    }
    public function paymentsPage() {
        $myData = $this->me();
        $myId = $myData->id;

        $payment = PaymentCtrl::mine($myId);
        return view('user.payment')->with(['payment' => $payment]);
    }
    public function logout() {
        $loggingOut = Auth::guard('user')->logout();
        return redirect()->route('user.login');
    }
    public function ticketsPage() {
        $myData = $this->me();
        $myTickets = TicketCtrl::mine($myData->id);
        return view('user.tickets')->with([
            'myData' => $myData,
            'tickets' => $myTickets,
        ]);
    }
}
