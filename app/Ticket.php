<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['event_id','name','price','stock'];

    public function events() {
        return $this->belongsTo('App\Event', 'event_id');
    }
}
