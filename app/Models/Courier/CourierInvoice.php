<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierInvoice extends Model
{
    use HasFactory;

    protected $table = "courier_invoice";

      protected $guarded = ['id','_token'];

    public function  route(){
    
        return $this->belongsTo('App\Models\Tariff','tariff_id');
      }

      public function supplier(){
    
        return $this->belongsTo('App\Models\Courier\CourierClient','owner_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }

 public function assign(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }
}
