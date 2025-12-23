<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Model;

class Billing_Type extends Model
{
    protected $table = "tbl_billing_type";

    protected $guarded = ['id'];
    
      public function project()
    {
        return $this->hasMany('App\Models\Project\Project', 'billing_id');
    }
  



}