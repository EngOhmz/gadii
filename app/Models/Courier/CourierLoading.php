<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierLoading extends Model
{
    use HasFactory;
    protected $table = "courier_loading";

  
   protected $guarded = ['id','_token'];


       public function  client(){
    
        return $this->belongsTo('App\Models\Courier\CourierClient','owner_id');
      }
     public function  courier(){
    
        return $this->belongsTo('App\Models\Courier\Courier','pacel_id');
      }
        public function start(){
    
        return $this->belongsTo('App\Models\Region','start_location');
      }
       public function end(){
    
        return $this->belongsTo('App\Models\Region','end_location');
      }

       public function route(){
    
        return $this->belongsTo('App\Models\Tariff','tariff_id');
      }
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

public function collect(){
    
        return $this->belongsTo('App\Models\Courier\CourierCollection','collection_id');
      }
}
