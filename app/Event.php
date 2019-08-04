<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title','cover','description','category','date_start','date_end','time_start','time_end',
        'user_id'
    ];
}
