<?php

namespace App\Models\Performance;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $table = "tbl_performance_indicator";

    protected $guarded = ['id'];
    
      public function department()
    {
        return $this->belongsTo('App\Models\Departments', 'department_id');
    }
    
    
public function assign()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }


}
