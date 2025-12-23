<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "tbl_project_comment";

    protected $guarded = ['id'];


public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }
    
   



}