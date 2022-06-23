<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryList extends Model
{
    use HasFactory;

    protected $table = "inventory_list";

   protected $fillable = [
    'serial_no',
   'reference',
    'brand_id',
    'purchase_id',
    'purchase_date',
    'location',
    'truck_id',
    'status',  
    'assign_reference',
    'added_by'];
    
    public function brand(){

        return $this->belongsTo('App\Models\Inventory','brand_id');
      }
    
      public function  tyre_location(){
    
        return $this->belongsTo('App\Models\Location','location');
      }
    
      public function  truck(){
          return $this->belongsTo('App\Models\Truck','truck_id');
      }
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
}
