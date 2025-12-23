<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = "pharmacy_pos_activities";

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
