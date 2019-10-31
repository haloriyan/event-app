<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title','cover','description','category','city','address','date_start','date_end','time_start','time_end',
        'user_id','status'
    ];

    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tickets() {
        return $this->hasMany('App\Ticket', 'event_id');
    }
}
