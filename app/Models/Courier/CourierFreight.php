<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierFreight extends Model
{
    use HasFactory;
    protected $table = "courier_freight";

  
   protected $guarded = ['id','_token'];


   
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
