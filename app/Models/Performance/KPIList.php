<?php

namespace App\Models\Performance;

use Illuminate\Database\Eloquent\Model;

class KPIList extends Model
{
    protected $table = "tbl_kpi_list";

    protected $guarded = ['id'];
    
      public function department()
    {
        return $this->belongsTo('App\Models\Departments', 'department_id');
    }
    
     public function designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }
    
    
public function assign()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


}
