<?php

namespace App\Http\Controllers;

use Auth;
use App\Category;
use Illuminate\Http\Request;

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
    public function dashboard() {
        return view('admin.dashboard');
    }
    public function categoryPage() {
        $cats = Category::all();
        return view('admin.category')->with(['categories' => $cats]);
    }
}
