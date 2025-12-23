<?php

namespace App\Models\Fuel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefillPayment extends Model
{
    use HasFactory;

    protected $table = "refill_payments";

   protected  $guarded = ['id'];

        public function fuel(){

            return $this->belongsTo('App\Models\Fuel\Fuel','fuel_id');
          }

       
         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
