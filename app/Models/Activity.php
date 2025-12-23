<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = "ema_activities";

    protected $guarded = ['id'];
    
   
    public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

     
}
