<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrrigationSystem extends Model
{
    use HasFactory;

    protected $table = "tbl_irrigation_systems";

    protected $fillable = ['added_by','name','status'];
}
