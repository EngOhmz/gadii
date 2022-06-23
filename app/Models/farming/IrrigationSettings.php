<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrrigationSettings extends Model
{
    use HasFactory;

    protected $table = "tbl_irrigation_settings";

    protected $fillable = ['irrigation_type','method','total_cost','added_by'];

}
