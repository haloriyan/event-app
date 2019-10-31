<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public static function get() {
        return City::orderBy('city', 'ASC')->get();
    }
    public function store(Request $req) {
        $city = City::create([
            'city' => $req->city
        ]);
        return redirect()->route('admin.city');
    }
    public function delete($id) {
        $del = City::find($id)->delete();
        return redirect()->route('admin.city');
    }
}
