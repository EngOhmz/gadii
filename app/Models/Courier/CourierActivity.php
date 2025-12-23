<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierActivity extends Model
{
    use HasFactory;

    protected $table = "courier_activities";

    protected $guarded = ['id'];
    
   
    public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
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
         
           public function  courier(){
    
        return $this->belongsTo('App\Models\Courier\Courier','module_id');
      }
     
}
