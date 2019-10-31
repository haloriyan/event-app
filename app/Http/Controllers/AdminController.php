<?php

namespace App\Http\Controllers;

use Auth;
use App\Category;
use Illuminate\Http\Request;
use \App\Http\Controllers\EventController as EventCtrl;
use \App\Http\Controllers\UserController as UserCtrl;
use \App\Http\Controllers\CityController as CityCtrl;

class AdminController extends Controller
{
    public function loginPage() {
        return view('admin.login');
    }
    public function login(Request $req) {
        $email = $req->email;
        $password = $req->password;

        $login = Auth::guard('admin')->attempt(['email' => $email, 'password' => $password]);
        if(!$login) {
            return redirect()->route('admin.loginPage')->withErrors(['Email / Password salah!']);
        }

        return redirect()->route('admin.dashboard');
    }
    public function logout() {
        $logout = Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    public function dashboard() {
        $dateNow = date('Y-m-d');
        $events = EventCtrl::countEvent();

        $users = UserCtrl::countUser();

        return view('admin.dashboard')->with([
            'events' => $events,
            'users' => $users,
        ]);
    }
    public function categoryPage() {
        $cats = Category::all();
        return view('admin.category')->with(['categories' => $cats]);
    }
    public function eventPage() {
        $dateNow = date('Y-m-d');
        $events = EventCtrl::active($dateNow);
        return view('admin.event')->with(['events' => $events]);
    }
    public function cityPage() {
        $cities = CityCtrl::get();
        return view('admin.city')->with(['cities' => $cities]);
    }
}
