<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    use HasFactory;

    protected $table = "inventory_histories";

    protected $guarded = ['id'];
    
      public function purchase(){

        return $this->belongsTo('App\Models\PurchaseInventory','purchase_id');
    }
    

 
public function supplier(){

    return $this->BelongsTo('App\Models\Supplier','supplier_id');
}
 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
      
      
      public function user(){

    return $this->BelongsTo('App\Models\User','user_id');
}
      
    
}
