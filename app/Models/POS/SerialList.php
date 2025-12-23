<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialList extends Model
{
    use HasFactory;
    protected $table = "pos_serial_list";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->belongsTo('App\Models\POS\Purchase','purchase_id');
    }
    
 
 public function brand(){

        return $this->belongsTo('App\Models\POS\Items','brand_id');
      }
    
      public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
