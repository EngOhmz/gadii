<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyreDisposal extends Model
{
    use HasFactory;

    protected $table = "tyre_disposals";

    protected  $guarded = ['id'];
    
      public function tyre_staff()
    {
         return $this->belongsTo('App\Models\FieldStaff','staff');
        //return $this->belongsTo('App\Models\User','staff');
    }

 
   
}
