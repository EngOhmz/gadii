<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingType extends Model
{
    use HasFactory;

    protected $table = "tbl_parking_types";

    protected $fillable = ['parking_name','added_by'];
}
