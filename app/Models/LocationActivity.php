<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  LocationActivity extends Model
{
    use HasFactory;

    protected $table = "location_activities";

    protected $fillable = [
    'module_id',
    'module',
    'date',
    'activity', 
    'added_by'];
    
   
    public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

     
}
