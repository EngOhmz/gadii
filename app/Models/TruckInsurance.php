<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckInsurance extends Model
{
    use HasFactory;
    protected $table = "truck_insurances";

    protected $fillable = [      
        'broker_name',
        'company',
        'expire_date',
        'cover',  
        'value',      
        'cover_date',
        'truck_id',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
