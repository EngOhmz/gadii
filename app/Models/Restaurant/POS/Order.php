<?php

namespace App\Models\Restaurant\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;
    
    protected $table       = 'order';
    protected $guarded     = ['id','_token'];
   
  

    public function user()
    {
        return $this->belongsTo('App\Models\User','added_by');
    }
  public function assign()
    {
        return $this->belongsTo('App\Models\User','user_agent');
    }
    public function store()
    {
        return $this->belongsTo('App\Models\Location','location');
   
    }

 public function client()
    {
        return $this->belongsTo('App\Models\Client','client_id');
   
    }
   

   

    
}
