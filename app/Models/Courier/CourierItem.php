<?php

namespace App\Models\Courier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierItem extends Model
{
    use HasFactory;

    protected $table = "courier_items";

    protected $guarded = ['id','_token'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
public function to(){
    
        return $this->belongsTo('App\Models\Region','to_region_id');
      }

public function item(){
    
        return $this->belongsTo('App\Models\Tariff','item_name');
      }
}
