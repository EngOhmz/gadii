<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PurchaseHistory extends Model
{
    use HasFactory;
    protected $table = "retail_pos_purchases_history";
    protected  $guarded = ['id','_token'];


   public function purchase(){

        return $this->BelongsTo('App\Models\Retail\Purchase','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Retail\Supplier','supplier_id');
}

 public function brand(){

        return $this->belongsTo('App\Models\Retail\Items','item_id');
      }
    
      public function  store(){
    
        return $this->belongsTo('App\Models\Retail\Location','location');
      }


}
