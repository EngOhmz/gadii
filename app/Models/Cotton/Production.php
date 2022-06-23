<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;
    protected $table = 'tbl_production';

    protected $fillable = ['weight_note','date','location','lot_no','client','bale_weight','net_weight','gross_weight','tale','remarks','name','company','status','bale_no'];

    public function productionList()
    {
        return $this->hasMany('App\Models\Cotton\ProductionList');
    }

   
}