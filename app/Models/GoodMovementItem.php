<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodMovementItem extends Model
{
    use HasFactory;

    protected $table  = "good_movement_items";

    protected $guarded = ['id'];

    public function source(){

        return $this->BelongsTo('App\Models\Location','source_store');
    }

   public function destination(){

        return $this->BelongsTo('App\Models\Location','destination_store');
    }
    
  public function item(){

        return $this->BelongsTo('App\Models\InventoryList','item_id');
    }
    
     public function brand(){

        return $this->BelongsTo('App\Models\Inventory','brand_id');
    }

  public function issue(){

        return $this->BelongsTo('App\Models\GoodkMovement','issue_id');
    }


    
}
