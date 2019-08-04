<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController as UserCtrl;

class ContactController extends Controller
{
    public static function mine($userId) {
        return Contact::where('user_id', $userId)->get();
    }
    public function store(Request $req) {
        $myData = UserCtrl::me();
        
        $cont = new Contact;
        $cont->user_id = $myData->id;
        $cont->type = $req->type;
        $cont->value = $req->value;
        $cont->save();

        return redirect()->route('user.settings');
    }
    public function delete($id) {
        $cont = Contact::find($id);
        $cont->delete();

        return redirect()->route('user.settings');
    }
}
