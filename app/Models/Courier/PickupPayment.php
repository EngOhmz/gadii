<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupPayment extends Model
{
    use HasFactory;

    protected $table = "courier_pickup_payments";

   protected  $guarded = ['id'];

     
         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
