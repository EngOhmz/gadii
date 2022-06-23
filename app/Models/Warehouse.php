<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $table = "tbl_warehouses";

    protected $fillable = ['id','warehouse_name','added_by','warehouse_manager','region_id','district_id','manager_contact','insurance_id'];
    public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }
    public function insurance()
    {
        return $this->belongsTo('App\Models\Insurance');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District','district_id');
    }

    public function farmer_account()
    {
        return $this->hasMany('App\Models\Farmer_account','id');
    }
  
}