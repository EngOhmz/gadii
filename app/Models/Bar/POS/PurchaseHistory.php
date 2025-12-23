<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    use HasFactory;

    protected $table = "store_pos_purchases_history";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->belongsTo('App\Models\Bar\POS\Purchase','purchase_id');
    }
    

 
public function supplier(){

    return $this->BelongsTo('App\Models\Bar\POS\Supplier','supplier_id');
}
 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
