<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreReturn extends Model
{
    use HasFactory;

    protected $table = "tyre_returns";

    protected  $guarded = ['id'];
    
    public function tyre_staff(){
         return $this->belongsTo('App\Models\FieldStaff','staff');
        //return $this->belongsTo('App\Models\User','staff');
      }
    
      public function  tyre_location(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
    
      public function truck(){
          return $this->belongsTo('App\Models\Truck','truck_id');
      }
      public function tyre_no(){
        return $this->belongsTo('App\Models\Tyre\Tyre','tyre_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
