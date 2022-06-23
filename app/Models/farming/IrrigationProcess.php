<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrrigationProcess extends Model
{
    use HasFactory;

    protected $table = "tbl_irrigation_processes";

    protected $fillable = ['irrigation_date','water_volume','next_date','cost_per_heck','no_of_heck','total_volume','added_by','seasson_id'];
}
