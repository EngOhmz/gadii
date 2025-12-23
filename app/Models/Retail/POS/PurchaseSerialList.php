<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PurchaseSerialList extends Model
{
    use HasFactory;
    protected $table = "pos_serial_list";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->hasMany('App\Models\POS\PurchaseSerial','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Supplier','supplier_id');
}

 public function brand(){

        return $this->belongsTo('App\Models\Inventory','brand_id');
      }
    
      public function  location(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
