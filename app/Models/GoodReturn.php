<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReturn extends Model
{
    use HasFactory;

    protected $table = "good_returns";

    protected $fillable = [
         'date',
        'staff',   
        'location',  
        'truck',  
       'item_id',
     'status',
        'added_by'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

 public function item()
    {
        return $this->belongsTo('App\Models\InventoryList','item_id');
    }

}
