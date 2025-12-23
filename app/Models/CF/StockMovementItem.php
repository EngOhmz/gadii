<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovementItem extends Model
{
    use HasFactory;

    protected $table  = "cf_stock_movement_items";

    protected $guarded = ['id'];

    public function source(){

        return $this->BelongsTo('App\Models\Location','source_store');
    }

   public function destination(){

        return $this->BelongsTo('App\Models\Location','destination_store');
    }
    
  public function item(){

        return $this->BelongsTo('App\Models\POS\Items','item_id');
    }

  public function issue(){

        return $this->BelongsTo('App\Models\POS\StockMovement','issue_id');
    }


    
}
