<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PurchaseSerialHistory extends Model
{
    use HasFactory;
    protected $table = "retail_pos_purchases_serial_history";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->hasMany('App\Models\Retail\PurchaseSerial','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Retail\Supplier','supplier_id');
}
}
