<?php

namespace App\Models\Radio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    use HasFactory;

    protected $table = "radio";

      protected $guarded = ['id','_token'];

   

      public function  supplier(){
    
        return $this->belongsTo('App\Models\Client','owner_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }


      
}
