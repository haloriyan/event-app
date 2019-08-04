<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ContactController as ContactCtrl;
use App\Http\Controllers\EventController as EventCtrl;

class UserController extends Controller
{
    public static function me() {
        return Auth::guard('user')->user();
    }
    public function loginPage() {
        return view('user.login');
    }
    public function registerPage() {
        return view('user.register');
    }
    public function login(Request $req) {
        $email = $req->email;
        $password = $req->password;

        $login = Auth::guard('user')->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if(!$login) {
            return redirect()->route('user.loginPage')->withErrors(['Email / Password salah!']);
        }

        return redirect()->route('user.dashboard');
    }
    public function register(Request $req) {
        $validateData = $this->validate($req, [
            'name' => 'required',
            'email' => 'email',
            'password' => 'min:6',
        ]);

        $reg = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'photo' => 'default.png',
        ]);

        return redirect()->route('user.dashboard');
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
}
