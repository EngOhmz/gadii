<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CottonPayment extends Model
{
    use HasFactory;

  protected $table = "cotton_payments";

     protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }


}
