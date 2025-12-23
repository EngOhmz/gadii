<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    protected $table = "tbl_task_assignment";

    protected $guarded = ['id'];
    
      public function task()
    {
        return $this->belongsTo('App\Models\Project\Task', 'task_id');
    }
  

  public function assign()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}