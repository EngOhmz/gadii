<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoLoading extends Model
{
    use HasFactory;
    protected $table = "cargo_loading";

    protected $fillable = [      
        'truck_id',
     'driver_id',
        'weight',
     'total_weight',
        'status',
       'amount',
    'fuel',
 'type',
  'route_id',
'start_location',
'end_location',
 'from_region_id',
'to_region_id',
'end',
 'item_id',
'quantity',
 'collection_date',
'receiver_name',
'owner_id',
  'collection_id',
    'pacel_id', 
   'pacel_name', 
  'pacel_number', 
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
         
    public function region_s(){
    
        return $this->belongsTo('App\Models\Region','from_region_id');
      }

    public function region_e(){
    
        return $this->belongsTo('App\Models\Region','to_region_id');
      }
     public function pacel(){
    
        return $this->belongsTo('App\Models\Pacel\Pacel','pacel_id');
      }
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
