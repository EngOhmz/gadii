<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeds_type extends Model
{
    use HasFactory;

    protected $table="tbl_seed_types";

    protected $fillable = ['added_by','name','age','soil_type','water_volume','harvest_volume','properties','status'];

    public function sowing(){

        return $this->hasMany('App\Models\farming\Sowing','id');
    }
}
