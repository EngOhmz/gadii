<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryPayment extends Model
{
    use HasFactory;

    protected $table = "inventory_payments";

   protected $guarded = ['id','token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    
     public function payment(){
    
        return $this->BelongsTo('App\Models\AccountCodes','account_id');
    }
    
    public function purchase(){
    
        return $this->BelongsTo('App\Models\PurchaseInventory','purchase_id');
    }
}
