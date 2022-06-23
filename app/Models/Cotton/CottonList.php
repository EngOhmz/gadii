<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CottonList extends Model
{
    use HasFactory;

    protected $table = "cotton_list";

    protected $fillable = [
    'serial_no',
    'brand_id',
    'purchase_id',
    'purchase_date',
    'location',
    'truck_id',
    'status',  
    'added_by'];
    
    public function brand(){

        return $this->belongsTo('App\Models\Cotton\Cotton','brand_id');
      }
    
      public function  tyre_location(){
    
        return $this->belongsTo('App\Models\Cotton\CollectionCenter','location');
      }
    
  
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
