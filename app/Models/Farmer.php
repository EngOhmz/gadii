<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;
    protected $table = "farmers";

    protected $fillable = ['firstname','lastname','phone','email','region_id','district_id','ward_id','address','group_id','user_id','assign'];

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
    public function land()
    {
        return $this->hasMany('App\Models\FarmLand');
    }
     public function farmer_account()
    {
        return $this->hasMany('App\Models\Farmer_account');
    }

  public function region()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District','district_id');
    }
    public function ward()
    {
        return $this->belongsTo('App\Models\Ward','ward_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','assign');
    }
}
