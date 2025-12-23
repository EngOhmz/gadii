<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mileage extends Model
{
    use HasFactory;
    protected $table = "mileages";

    protected $guarded = ['id','_token'];
        public function route(){

            return $this->belongsTo('App\Models\Route','route_id');
          }

          public function truck(){

            return $this->belongsTo('App\Models\Truck','truck_id');
          }

         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
