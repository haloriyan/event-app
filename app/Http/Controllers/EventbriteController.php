<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventbriteController extends Controller
{
    public function auth() {
        $endpoint = "https://www.eventbrite.com/oauth/authorize";
    }
    public function accessToken() {
        $endpoint = "https://www.eventbrite.com/oauth/token";

        $c = new \GuzzleHttp\Client();
        $req = $c->request('POST', $endpoint, []);
        echo $req;
    }
}
