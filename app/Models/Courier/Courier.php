<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $table = "courier";

      protected $guarded = ['id','_token'];

    public function  route(){
    
        return $this->belongsTo('App\Models\Tariff','tariff_id');
      }

      public function  supplier(){
    
        return $this->belongsTo('App\Models\Courier\CourierClient','owner_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

public function from(){
    
        return $this->belongsTo('App\Models\Region','from_region_id');
      }
      
}
