<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "tbl_project";

    protected $guarded = ['id'];
    
      public function department()
    {
        return $this->belongsTo('App\Models\Departments', 'department_id');
    }
       public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
      public function category()
    {
        return $this->belongsTo('App\Models\Project\Category', 'category_id');
    }
    
       public function billing_type()
    {
        return $this->belongsTo('App\Models\Project\Billing_Type', 'billing_id');
    }
    



}
