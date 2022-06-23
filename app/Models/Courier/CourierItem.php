<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierItem extends Model
{
    use HasFactory;

    protected $table = "courier_items";

    protected $fillable = [
    'pacel_id',
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
