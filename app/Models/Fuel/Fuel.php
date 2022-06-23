<?php

namespace App\Models\Fuel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;
    protected $table = "fuels";

    protected $fillable = [      
        'truck_id',
     'driver_id',
        'route_id',
        'fuel_rate',
        'fuel_used',  
        'due_fuel',      
        'fuel_adjustment',
        'reason',
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
