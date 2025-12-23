<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInventory extends Model
{
    use HasFactory;

    protected $table = "purchase_inventories";

   protected  $guarded = ['id'];
    
  public function user()
    {
        return $this->belongsTo('App\Models\User','user_agent');
    }

 public function  supplier(){
    
        return $this->belongsTo('App\Models\Supplier','supplier_id');
      }

}
