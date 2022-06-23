<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = "service_items";

    protected $fillable = [      
         'truck',
         'service_id',  
        'minor',  
        'order_no', 
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
