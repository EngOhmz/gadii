<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreReturnItems extends Model
{
    use HasFactory;

    protected $table = "tyre_returns_items";

    protected  $guarded = ['id'];
    
  
    
      public function truck(){
          return $this->belongsTo('App\Models\Truck','truck_id');
      }
      public function tyre(){
        return $this->belongsTo('App\Models\Tyre\Tyre','item_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
