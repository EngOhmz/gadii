<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crops_type extends Model
{
    use HasFactory;
    protected $table = "tbl_crops_types";


    protected $fillable = ['crop_name','storage_type','status','crop_category','added_by'];
    
    public function farmer_account()
    {
        return $this->hasMany('App\Models\Farmer_account','id');
    }

    public function sowing(){

        return $this->hasMany('App\Models\farming\Sowing','id');
    }
  
}