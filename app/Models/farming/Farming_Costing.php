<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farming_Costing extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "tbl_farming_costing";

    protected $fillable = ['farm_id','farmer_id','user_id'];


    public function costs(){

        return $this->hasMany('App\Models\farming\Farming_Costing_Details','farming_cost_id');
    }

    public function crops_type(){

        return $this->belongsTo('App\Models\Crops_type','crop_type');
    }
}
