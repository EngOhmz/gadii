<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreparationDetails extends Model
{
    use HasFactory;

    protected $table = "tbl_preparation_details";

    protected $fillable = ['user_id','seasson_id','organization_id','preparation_type','soil_salt','acid_level','moisture_level','lime_control','status', 'cost','weight', 'acre','total_cost'];
       

    public function preparationCostList(){

       return  $this->hasMany('App\farming\PreparationCostList','id');
    }
}
