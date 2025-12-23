<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $table = "tbl_cf_milestone";

    protected $guarded = ['id'];
    
      public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
      public function category()
    {
        return $this->belongsTo('App\Models\CF\Category', 'category_id');
    }
    
       public function billing_type()
    {
        return $this->belongsTo('App\Models\CF\Billing_Type', 'billing_id');
    }
    
 public function assign()
    {
        return $this->belongsTo('App\Models\User', 'responsible_id');
    }


}
