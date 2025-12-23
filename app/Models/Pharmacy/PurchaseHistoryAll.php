<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PurchaseHistoryAll extends Model
{
    use HasFactory;
    protected $table = "pharmacy_pos_all_type_purchases_history";
    protected  $guarded = ['id','_token'];


   public function purchase(){

        return $this->BelongsTo('App\Models\Pharmacy\Purchase','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Pharmacy\Supplier','supplier_id');
}

 public function brand(){

        return $this->belongsTo('App\Models\Pharmacy\Items','item_id');
      }
    
      public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }


}
