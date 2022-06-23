<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimeBase extends Model
{
    use HasFactory;
    protected $table = "lime_base";


    protected $fillable = ['name','type','added_by'];
    
  
  
}