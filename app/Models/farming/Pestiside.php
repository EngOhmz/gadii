<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pestiside extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "tbl_pestisides";

    protected $fillable = ['pestiside_type','farming_process','pestiside_amount','total_amount','pestiside_price','pestiside_cost','user_id','seasson_id','no_hector','pesticide_name','total_cost'];


    public function farming_processes(){

        return $this->belongsTo('App\Models\Farming_process','farming_process');
    }

    public function crops_type(){

        return $this->belongsTo('App\Models\Crops_type','crop_type');
    }
    public function pesticide(){

        return $this->belongsTo('App\Models\PesticideType','pesticide_name');
    }
}
