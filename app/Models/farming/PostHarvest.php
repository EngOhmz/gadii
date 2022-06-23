<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHarvest extends Model
{
    use HasFactory;

    protected $table = "tbl_post_harvests";

   protected $fillable = [
 'category' ,    
   'harvest_method' , 
    'maturity_index' , 
    'maturity_level' , 
    'harvest_date' , 
      'packing_type' , 
   'drying_method' , 
'warehouse_id',
    'market' ,    
    'water' , 
    'cost' , 
     'acre' , 
    'total_cost' , 
'total_harvest',
'harvest_amount',
    'user_id' , 
    'seasson_id' ,
];

    
}
