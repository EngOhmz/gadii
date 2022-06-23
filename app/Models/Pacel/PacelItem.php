<?php

namespace App\Models\Pacel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacelItem extends Model
{
    use HasFactory;

    protected $table = "pacel_items";

    protected $fillable = [
    'pacel_id',
    'item_name',
    'tax_rate',
    'total_tax',
    'quantity',
    'total_cost',
    'price',
    'unit',  
   'distance',
      'charge_type',       
    'items_id',           
    'order_no',      
    'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
