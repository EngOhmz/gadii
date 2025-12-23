<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;
    protected $table = "trucks";

 protected $fillable = ['truck_name','reg_no','driver','truck_type','capacity','driver_status','fuel','truck_status','tyre','staff','location','reading','connect_horse','connect_trailer','added_by','type','disabled'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }

    public function assign()
    {
        return $this->belongsTo('App\Models\Driver','driver');
    }
          
public function region()
    {
        return $this->belongsTo('App\Models\Region','location');
    }
 public function  movement_crop_types(){

        return $this->belongsTo('App\Models\Crops_type','crop_type');
      }
public function route()
    {
        return $this->belongsTo('App\Models\Route','route_id');
    }
}
