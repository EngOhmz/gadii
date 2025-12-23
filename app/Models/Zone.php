<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    //
 protected $guarded = ['id','_token'];


public function client(){
    
        return $this->belongsTo('App\Models\Courier\CourierClient','client_id');
      }
}
