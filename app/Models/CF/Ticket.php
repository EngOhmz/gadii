<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tbl_tickets";

    protected $guarded = ['id'];
    
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
