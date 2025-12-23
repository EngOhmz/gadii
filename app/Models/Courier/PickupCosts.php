<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupCosts extends Model
{
    use HasFactory;

    protected $table = "courier_pickup_costs";

   protected  $guarded = ['id'];

        public function pacel(){

            return $this->belongsTo('App\Models\Courier\Courier','pacel_id');
          }

          public function owner(){

            return $this->belongsTo('App\Models\Driver','supplier');
          }

         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
