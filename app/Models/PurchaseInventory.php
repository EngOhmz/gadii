<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInventory extends Model
{
    use HasFactory;

    protected $table = "purchase_inventories";

    protected $fillable = [
    'reference_no',
    'supplier_id',
    'purchase_date',
    'due_date',
    'location',
    'exchange_code',
    'exchange_rate',
    'purchase_amount',
    'due_amount',
    'purchase_tax',
    'status',
    'good_receive',    
    'added_by'];
    
  public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }

 public function  supplier(){
    
        return $this->belongsTo('App\Models\Supplier','supplier_id');
      }

}
