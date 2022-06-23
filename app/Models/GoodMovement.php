<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodMovement extends Model
{
    use HasFactory;

    protected $table = "good_movements";

    protected $fillable = [
         'date',      
       'item_id',
        'staff',   
        'source_location',  
       'destination_location',            
        'quantity', 
      'status',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
