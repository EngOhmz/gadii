<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  PurchaseHistory extends Model
{
    use HasFactory;
    protected $table = "pos_purchases_history";
    protected  $guarded = ['id','_token'];


    public function purchase(){

        return $this->hasMany('App\Models\POS\Purchase','purchase_id');
    }
    
 
public function supplier(){

    return $this->BelongsTo('App\Models\Supplier','supplier_id');
}
}
