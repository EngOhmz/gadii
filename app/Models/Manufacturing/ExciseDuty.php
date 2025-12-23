<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExciseDuty extends Model
{
    use HasFactory; 
    

    protected $table = "tbl_excise_duty";
    
    protected $guarded = ['id'];


}
