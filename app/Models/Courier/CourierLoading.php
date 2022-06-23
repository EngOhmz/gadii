<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierLoading extends Model
{
    use HasFactory;
    protected $table = "courier_loading";

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
 'collection_date',
'receiver_name',
'owner_id',
    'pacel_id', 
   'pacel_name', 
  'pacel_number', 
        'added_by'];

      
   public function  client(){
    
        return $this->belongsTo('App\Models\Courier\CourierClient','owner_id');
      }
      public function route(){
    
        return $this->belongsTo('App\Models\Route','route_id');
      }
        
         
    public function region_s(){
    
        return $this->belongsTo('App\Models\Region','start_location');
      }

    public function region_e(){
    
        return $this->belongsTo('App\Models\Region','end_location');
      }
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
