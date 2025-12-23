<?php

namespace App\Models\Leads;

use Illuminate\Database\Eloquent\Model;

class MeetingsAttendees extends Model
{
    protected $table = "tbl_meetings_attendees";

    protected $guarded = ['id'];
    
    
 public function assign(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }



}
