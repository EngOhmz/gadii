<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    use HasFactory;

    protected $table = "manufacturing_inventory_histories";

    protected $fillable = [
    'purchase_id',
    'items_id', 
    'quantity',                 
     'supplier_id',
    'purchase_date', 
     'location',  
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
