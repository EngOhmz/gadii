<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    use HasFactory;
    
    protected $table       = 'order_items';
    protected $guarded     = ['id','_token'];
   
  


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function place()
    {
        return $this->belongsTo('App\Models\Location','location');
   
    }


   
   

    
}
