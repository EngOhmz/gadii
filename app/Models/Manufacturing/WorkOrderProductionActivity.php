<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderProductionActivity extends Model
{
    use HasFactory;

    protected $table = "work_orders_production_activity";
    
    protected $guarded = ['id'];


    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    
    // public function user()
    // {
    //     return $this->hasMany('App\Models\User','id', 'responsible_id');
    // }




}
