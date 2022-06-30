<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierActivity extends Model
{
    use HasFactory;

    protected $table = "courier_activities";

    protected $fillable = [
    'module_id',
    'module',
    'date',
    'activity',
    'notes',   
'loading_id',
    'added_by'];
    
   
    public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

     
}
