<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreReallocationItems extends Model
{
    use HasFactory;

    protected $table = "tyre_reallocation_items";

    protected  $guarded = ['id'];
    
  
    
      public function truck(){
          return $this->belongsTo('App\Models\Truck','truck_id');
      }
      public function s_tyre(){
          return $this->belongsTo('App\Models\Tyre\Tyre','source_tyre');
      }
      public function d_tyre(){
        return $this->belongsTo('App\Models\Tyre\Tyre','destination_tyre');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
