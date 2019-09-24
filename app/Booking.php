<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = "booking";

    protected $fillable = ['ticket_id','user_id','qty','total_pay','status'];

    public function ticketEvent() {
        return $this->hasOneThrough('App\Booking', 'App\Ticket', 'event_id', 'ticket_id');
    }
    public function tickets() {
        return $this->belongsTo('App\Ticket', 'ticket_id');
    }

    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
