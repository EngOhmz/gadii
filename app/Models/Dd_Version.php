<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dd_Version extends Model
{
    use HasFactory;
    
    protected $table = "db_Version";
    
    protected $guarded = ['id'];


    // protected $fillable = ['name','priority'];
    
    
  
}