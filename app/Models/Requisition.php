<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $table = "requisition";

      protected $guarded = ['id','_token'];

   public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }

   public function  supplier(){
    
        return $this->belongsTo('App\Models\Supplier','supplier_id');
      }

}
