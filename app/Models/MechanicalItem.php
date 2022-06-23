<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicalItem extends Model
{
    use HasFactory;

    protected $table = "mechanical_item";

    protected $fillable = [      
         'module',
         'module_id',
         'item_name',
         'order_no',
         'date',   
        'added_by'];
    
        public function service(){
    
        return $this->belongsTo('App\Models\ServiceType','item_name');
      }

}
