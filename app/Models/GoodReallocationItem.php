<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReallocationItem extends Model
{
    use HasFactory;

    protected $table  = "good_reallocation_items";

    protected $guarded = ['id'];

    public function source(){

        return $this->BelongsTo('App\Models\Truck','source_truck');
    }

   public function destination(){

        return $this->BelongsTo('App\Models\Truck','destination_truck');
    }
    
  public function item(){

        return $this->BelongsTo('App\Models\InventoryList','item_id');
    }
    
     public function brand(){

        return $this->BelongsTo('App\Models\Inventory','brand_id');
    }

  public function issue(){

        return $this->BelongsTo('App\Models\GoodReallocation','movement_id');
    }


    
}
