<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = "booking";

    protected $fillable = ['ticket_id','user_id','qty','total_pay','status'];
}
