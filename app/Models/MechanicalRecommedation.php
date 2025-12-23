<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicalRecommedation extends Model
{
    use HasFactory;

    protected $table = "mechanical_recommedation";

   protected $guarded = [
         'id',      
       'token'];
    
    
       
}
