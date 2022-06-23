<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $table = "courier";

    protected $fillable = [
    'pacel_name',
    'pacel_number',
    'date',
   'due_date',
    'owner_id',
    'confirmation_number',
    'weight',
    'route_id',
    'receiver_name',
        'docs',
        'non_docs',
        'bags',
        'mobile',
      'currency_code',
        'exchange_rate',
        'amount',
        'tax',
        'due_amount',
        'discount',
        'instructions',
    'status',
    'good_receive',    
    'added_by'];
    

    public function  route(){
    
        return $this->belongsTo('App\Models\Route','route_id');
      }

      public function  supplier(){
    
        return $this->belongsTo('App\Models\Courier\CourierClient','owner_id');
      }

 public function user(){
    
        return $this->belongsTo('App\Models\User','added_by');
      }
}
