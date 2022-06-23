<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReallocation extends Model
{
    use HasFactory;

    protected $table = "good_reallocations";

    protected $fillable = [
         'date',      
       'source_item',
       'destination_item',
        'staff',   
        'source_truck',  
       'destination_truck',            
        'quantity', 
       'status',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
