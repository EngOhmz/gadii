<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchases extends Model
{
    use HasFactory;

    protected $table = "inventory_return_purchases";
    protected  $guarded = ['id'];


    public function purchase(){

        return $this->BelongsTo('App\Models\PurchaseInventory','purchase_id');
    }
    
    public function supplier(){
    
        return $this->BelongsTo('App\Models\Supplier','supplier_id');
    }

public function assign(){

    return $this->BelongsTo('App\Models\User','user_id');
}

  public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','bank_id');
    }

}
