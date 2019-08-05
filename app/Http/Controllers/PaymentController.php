<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController as UserCtrl;

class PaymentController extends Controller
{
    public static function mine($myId) {
        return Payment::where('user_id', $myId)->get();
    }
    public function create() {
        return view('user.payment.create');
    }
    public function store(Request $req) {
        $myId = UserCtrl::me()->id;
        $create = Payment::create([
            'user_id'           => $myId,
            'type'              => $req->type,
            'account_name'      => $req->account_name,
            'account_id'        => $req->account_id,
        ]);

        return redirect()->route('user.payments');
    }
    public function delete($id) {
        $pay = Payment::find($id);
        $pay->delete();

        return redirect()->route('user.payments');
    }
}
