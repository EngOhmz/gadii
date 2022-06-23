<?php

namespace App\Models\farming;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fertilizer extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "tbl_fertilizers";

    protected $fillable = ['program','package','farming_process','fertilizer_amount','total_amount','fertilizer_price','fertilizer_cost','user_id','seasson_id','no_hector','total_cost'];


    public function farming_processes(){

        return $this->belongsTo('App\Models\Farming_process','farming_process');
    }

    public function crops_type(){

        return $this->belongsTo('App\Models\Crops_type','crop_type');
    }
}
