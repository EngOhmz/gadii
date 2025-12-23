<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketActivity extends Model
{
    use HasFactory;

    protected $table = "tbl_ticket_activities";

    protected $guarded = ['id'];
    
   
    public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

     
}
