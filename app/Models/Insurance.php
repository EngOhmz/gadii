<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $table = "tbl_insurances";

    protected $fillable = ['id','insurance_name','insurance_type','asset_value','insurance_amount','cover_age','start_date','end_date'];
   
}