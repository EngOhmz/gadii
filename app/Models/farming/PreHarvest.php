<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreHarvest extends Model
{
    use HasFactory;

    protected $table = "tbl_pre_harvests";

    protected $fillable = [
 'category' ,    
   'harvest_method' , 
    'maturity_index' , 
    'maturity_level' , 
    'harvest_date' , 
      'packing_type' , 
   'drying_method' , 
    'market' ,    
    'water' , 
    'cost' , 
     'acre' , 
'warehouse_id',
    'total_cost' , 
'total_harvest',
'harvest_amount',
    'user_id' , 
    'seasson_id' ,
];

      public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse','warehouse_id');
    }

}
