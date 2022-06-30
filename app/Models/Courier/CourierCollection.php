<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierCollection extends Model
{
    use HasFactory;
    protected $table = "courier_collection";

    protected $fillable = [      
        'weight',
     'due_weight',
        'status',
       'amount',
  'route_id',
'start_location',
'end_location',
'receiver_name',
'owner_id',
    'pacel_id', 
   'pacel_name', 
  'pacel_number', 
        'added_by'];

       public function  client(){
    
        return $this->belongsTo('App\Models\Courier\CourierClient','owner_id');
      }
      public function route(){
    
        return $this->belongsTo('App\Models\Route','route_id');
      }
         
         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
