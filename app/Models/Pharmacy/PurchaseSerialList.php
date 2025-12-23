<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PurchaseSerialList extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_purchases_serial_list";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->hasMany('App\Models\Pharmacy\PurchaseSerial','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Pharmacy\Supplier','supplier_id');
}

 public function brand(){

        return $this->belongsTo('App\Models\Pharmacy\Items','brand_id');
      }
    
      public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
