<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = "tbl_cf_assignment";

    protected $guarded = ['id'];
    
      public function project()
    {
        return $this->belongsTo('App\Models\Project\Project', 'project_id');
    }
  

  public function assign()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}