<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoCollection extends Model
{
    use HasFactory;
    protected $table = "cargo_collection";

   protected  $guarded = ['id'];

       public function  client(){
    
        return $this->belongsTo('App\Models\Client','owner_id');
      }
      public function route(){
    
        return $this->belongsTo('App\Models\Route','route_id');
      }
          public function truck(){

            return $this->belongsTo('App\Models\Truck','truck_id');
          }
     public function driver(){

            return $this->belongsTo('App\Models\Driver','driver_id');
          }
             public function pacel(){
    
        return $this->belongsTo('App\Models\Pacel\Pacel','pacel_id');
      }
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
