<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crops_Monitoring extends Model
{
    use HasFactory;

    protected $table = "tbl_crops_monitoring";

    protected $fillable = ['name','type','farm_id','course','symptoms','attachment','status','module','module_id','season_id','added_by'];
    public function farm()
    {
        return $this->belongsTo('App\Models\Land_properties','farm_id');
    }
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
      public function solutions()
    {
        return $this->hasOne('App\Models\Monitoring_Solutions','id');
    }
   
}
