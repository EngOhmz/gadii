<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckInsurance extends Model
{
    use HasFactory;
    protected $table = "truck_insurances";

     protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    
     public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier','broker_name');
    }

}
