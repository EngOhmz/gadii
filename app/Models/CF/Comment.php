<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "tbl_cf_comment";

    protected $guarded = ['id'];


public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }
    
   



}