<?php

namespace App\Models\Leads;

use Illuminate\Database\Eloquent\Model;

class Calls extends Model
{
    protected $table = "tbl_calls";

    protected $guarded = ['id'];
    
      public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }


    
 public function assign(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }



}
