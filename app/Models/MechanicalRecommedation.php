<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicalRecommedation extends Model
{
    use HasFactory;

    protected $table = "mechanical_recommedation";

    protected $fillable = [      
         'module',
         'module_id',
         'recommedation',
         'order_no',
         'date',   
        'added_by'];
    
       
}
