<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_items extends Model
{
    use HasFactory;

    protected $table = "tbl_purchase_items";

    protected $fillable = ['item_name','quantity','tax_rate','unit','price','total_cost','total_tax','items_id','order_no','purchase_id'];

    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase','purchase_id');
    }  
   
}
