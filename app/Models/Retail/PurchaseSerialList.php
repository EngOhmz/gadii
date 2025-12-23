<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PurchaseSerialList extends Model
{
    use HasFactory;
    protected $table = "retail_pos_purchases_serial_list";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->hasMany('App\Models\Retail\PurchaseSerial','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Retail\Supplier','supplier_id');
}

 public function brand(){

        return $this->belongsTo('App\Models\Retail\Items','brand_id');
      }
    
      public function  store(){
    
        return $this->belongsTo('App\Models\Retail\Location','location');
      }
}
