<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierFreightItems extends Model
{
    use HasFactory;
    protected $table = "courier_freight_items";

  
   protected $guarded = ['id','_token'];


public function  client(){
    
        return $this->belongsTo('App\Models\Courier\CourierClient','owner_id');
      }
     public function  courier(){
    
        return $this->belongsTo('App\Models\Courier\Courier','pacel_id');
      }
      public function  route(){
    
        return $this->belongsTo('App\Models\Tariff','tariff_id');
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
