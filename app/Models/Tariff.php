<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    protected $table = "tariffs";

    protected $guarded = ['id','_token'];

        
    public function client()
    {
        return $this->belongsTo('App\Models\Courier\CourierClient','client_id');
    }  
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

 public function zonal()
    {
        return $this->belongsTo('App\Models\Zone','zone_id');
    }  

}
