<?php

namespace App\Models\Goal_Tracking;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $table = "tbl_goal_category";

    protected $guarded = ['id'];
    
      public function project()
    {
        return $this->hasMany('App\Models\Goal_Tracking\Project', 'billing_id');
    }
  



}