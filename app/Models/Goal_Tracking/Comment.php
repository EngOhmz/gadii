<?php

namespace App\Models\Goal_Tracking;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "tbl_goal_comment";

    protected $guarded = ['id'];


        public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }
    
   



}