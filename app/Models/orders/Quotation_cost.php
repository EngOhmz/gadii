<?php

namespace App\Models\orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation_cost extends Model
{
    use HasFactory;

    protected $table = "tbl_quotation_costs";

    protected $fillable = ['item_name','quantity','tax_rate','unit','price','total_cost','total_tax','items_id','order_no','quotation_id'];

    public function quotation_cost(){

        return $this->belongTo('App\Models\orders\Transport_quotation','quotation_id');
    }
    public function movement_quotation_cost(){

        return $this->belongTo('App\Models\orders\OrderMovement','quotation_id');
    }
}
