<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mileage extends Model
{
    use HasFactory;
    protected $table = "mileages";

    protected $fillable = [      
        'truck_id',
     'driver_id',
        'route_id',
        'fuel_rate',
       'total_mileage',
        'due_mileage',
        'fuel_adjustment',
        'reason',
'payment_status',
        'status_approve',
   'approved_by',
    'movement_id', 
        'added_by'];

        public function route(){

            return $this->belongsTo('App\Models\Route','route_id');
          }

          public function truck(){

            return $this->belongsTo('App\Models\Truck','truck_id');
          }

         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
