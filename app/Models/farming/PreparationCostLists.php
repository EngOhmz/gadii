<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreparationCostLists extends Model
{
    use HasFactory;

    protected $table = "tbl_preparation_cost_lists";

    protected $fillable = ['item_name','quantity','recomendation','price','total_cost','items_id','order_no','preparation_id'];


    public function preparationDetails(){

       return  $this->belongsTo('App\farming\PreparationDetails','preparation_id');
    }
}
