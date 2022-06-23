<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItemTyre extends Model
{
    use HasFactory;
    protected $table = "purchase_item_tyres";

    protected $fillable = [
    'purchase_id',
    'item_name',
    'tax_rate',
    'total_tax',
    'quantity',
    'total_cost',
    'price',
    'unit',        
    'items_id',           
    'order_no',      
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
