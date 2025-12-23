<?php

namespace App\Models\Goal_Tracking;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $table = "tbl_goal_milestone";

    protected $guarded = ['id'];
    
      public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
      public function category()
    {
        return $this->belongsTo('App\Models\Goal_Tracking\Category', 'category_id');
    }
    
       public function billing_type()
    {
        return $this->belongsTo('App\Models\Goal_Tracking\Billing_Type', 'billing_id');
    }
    
 


}
