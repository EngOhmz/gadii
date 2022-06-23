<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_items extends Model
{
    use HasFactory;

    protected $table = "tbl_sales_items";

    protected $fillable = ['item_name','quantity','tax_rate','unit','price','total_cost','total_tax','items_id','order_no','invoice_id'];


    public function sales()
    {
        return $this->belongsTo('App\Models\Sales','sales_id');
    } 
}
