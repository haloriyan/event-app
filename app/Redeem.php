<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redeem extends Model
{
    protected $table = 'redeem';
    protected $fillable = ['event_id','saldo','status'];
    
}
