<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seasson extends Model
{
    use HasFactory;
    protected $table = "tbl_seassons";

    protected $fillable = ['seasson_name','farm_id','farmer_id','start_date','harvest_date','crop_name','user_id','status'];
    
    
    public function farm(){

        return $this->belongsTo('App\Models\Land_properties','farm_id');
    }
    public function farmer(){

        return $this->belongsTo('App\Models\Farmer','farmer_id');
    }

    public function preparation(){

        return $this->hasMany('App\Models\farming\PreparationDetails','seasson_id');
    }

public function crop()
    {
        return $this->belongsTo('App\Models\Crops_type','crop_name');
    }
}
