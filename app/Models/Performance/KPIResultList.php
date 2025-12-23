<?php

namespace App\Models\Performance;

use Illuminate\Database\Eloquent\Model;

class KPIResultList extends Model
{
    protected $table = "tbl_kpi_result_list";

    protected $guarded = ['id'];
    
    
     public function list()
    {
        return $this->belongsTo('App\Models\Performance\KPIList', 'list_id');
    }

   public function goal()
    {
        return $this->belongsTo('App\Models\Goal_Tracking\GoalTracking', 'goal_id');
    } 
    
public function assign()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }




}