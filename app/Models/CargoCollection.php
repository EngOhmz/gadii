<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoCollection extends Model
{
    use HasFactory;
    protected $table = "cargo_collection";

    protected $fillable = [      
        'weight',
     'due_weight',
        'status',
       'amount',
  'route_id',
'start_location',
'end_location',
 'from_region_id',
'to_region_id',
 'end',
'receiver_name',
'owner_id',
 'item_id', 
 'quantity', 
    'pacel_id', 
   'pacel_name', 
  'pacel_number', 
'truck_id',
     'driver_id',
        'added_by'];

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
