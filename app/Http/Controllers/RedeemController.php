<?php

namespace App\Http\Controllers;

use App\Redeem;
use Illuminate\Http\Request;
use App\Http\Controllers\EventController as EventCtrl;
use App\Http\Controllers\UserController as UserCtrl;

class RedeemController extends Controller
{
    public static function mine($userId) {
        $mine = Redeem::where([
            ['user_id', $userId]
        ])->get();
        return $mine;
    }
    public function store(Request $req) {
        $myData = UserCtrl::me();

        $request = Redeem::create([
            'user_id' => $myData->id,
            'event_id' => $req->event_id,
            'saldo' => $req->saldo,
            'status' => 0,
        ]);

        $updateStatus = EventCtrl::change($req->event_id, [
            'status' => 8,
        ]);

        return redirect()->route('user.payments');
    }
    public function delete($id) {
        // 
    }
}
