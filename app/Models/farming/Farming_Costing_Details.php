<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farming_Costing_Details extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "tbl_farming_cost_items";

    protected $fillable = ['item_name','farming_cost_id','quantity','tax_rate','unit','price','total_cost','total_tax','items_id','order_no','purchase_id'];

    public function farming_cost()
    {
        return $this->belongsTo('App\Models\farming\Farming_Costing','id');
    }


    public function farming_processes(){

        return $this->belongsTo('App\Models\Farming_process','farming_process');
    }

    public function crops_type(){

        return $this->belongsTo('App\Models\Crops_type','crop_type');
    }
}
