<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'tbl_sales';
    protected $fillable = ['user_id','client_id','reference_no','invoice_amount','due_amount','due_date','invoice_date','status','exchange_rate','currency_code'];


    public function farmer()
    {
        return $this->belongsTo('App\Models\Farmer','client_id');
    }          

   
     public function sales_items()
    {
        return $this->hasMany('App\Models\Sales_items','invoice_id');
    }
    
}
