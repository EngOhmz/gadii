<?php

namespace App\Models\Fuel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refill extends Model
{
    use HasFactory;

    protected $table = "refills";

   protected  $guarded = ['id'];

        public function tariff(){

            return $this->belongsTo('App\Models\Route','route');
          }

          public function vehicle(){

            return $this->belongsTo('App\Models\Truck','truck');
          }

         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
