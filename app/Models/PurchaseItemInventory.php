<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItemInventory extends Model
{
    use HasFactory;

    protected $table = "purchase_item_inventories";

   protected  $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
