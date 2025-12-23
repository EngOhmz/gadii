<?php

namespace App\Models\CargoAgency\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = "tbl_cg_cars";

    protected $fillable = ['carNumber', 'status', 'driver_id', 'closeDate'];
    
   
}
