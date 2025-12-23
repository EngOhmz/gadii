<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'order_history';
    protected $guarded     = ['id','_token'];


public function invoice(){

        return $this->BelongsTo('App\Models\Restaurant\POS\Order','invoice_id');
    }


    
    public function client(){
    
        return $this->BelongsTo('App\Models\Client','client_id');
    }

 public function  store(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
   
}
