<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "tbl_cf_category";

    protected $guarded = ['id'];
    
      public function project()
    {
        return $this->hasMany('App\Models\Project\Project', 'billing_id');
    }
  



}