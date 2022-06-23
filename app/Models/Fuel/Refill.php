<?php

namespace App\Models\Fuel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refill extends Model
{
    use HasFactory;

    protected $table = "refills";

    protected $fillable = [      
        'truck',
        'route',
        'fuel_id',
        'litres',  
        'price', 
       'payment_type', 
        'account_id',     
        'total_cost',
        'added_by'];

        public function route(){

            return $this->belongsTo('App\Models\Route','route');
          }

          public function truck(){

            return $this->belongsTo('App\Models\Truck','truck');
          }

         
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
