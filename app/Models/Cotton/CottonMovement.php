<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CottonMovement extends Model
{
    use HasFactory;

    protected $table = "cotton_movement";

    protected $fillable = [
         'date',      
        'purchase_id',
        'staff',   
        'source_location',  
       'destination_location',   
'rate',
'distance',         
        'transport', 
'truck_id',
     'approve_by',
'status',
'status2',
'district_id',
'amount',
'quantity',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

 public function source()
    {
        return $this->belongsTo('App\Models\Cotton\CollectionCenter','source_location');
    }
 public function destination()
    {
        return $this->belongsTo('App\Models\Cotton\CollectionCenter','destination_location');
    }

 public function item()
    {
        return $this->belongsTo('App\Models\Cotton\PurchaseCotton','purchase_id');
    }
}
