<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionCenter extends Model
{
    use HasFactory;
    protected $table = "collection_centers";

    protected $fillable = ['id','name','amcos','added_by','district_id','account_codes','operator_id','quantity','head'];
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
public function ward()
    {
        return $this->belongsTo('App\Models\Ward','ward_id');
    }

    public function farmer_account()
    {
        return $this->hasMany('App\Models\Farmer_account','id');
    }
       public function purchaseCotton()
    {
        return $this->hasMany('App\Models\Cotton\PurchaseCotton','id');
    }
  public function operator()
    {
        return $this->belongsTo('App\Models\Cotton\Operator','operator_id');
    }
}