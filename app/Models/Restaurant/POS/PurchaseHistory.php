<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    use HasFactory;

    protected $table = "restaurant_pos_purchases_history";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->belongsTo('App\Models\Restaurant\POS\Purchase','purchase_id');
    }
    

 
public function supplier(){

    return $this->BelongsTo('App\Models\Restaurant\POS\Supplier','supplier_id');
}
 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
}
